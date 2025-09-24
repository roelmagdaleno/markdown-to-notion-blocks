<?php

declare(strict_types=1);

namespace RoelMR\MarkdownToNotionBlocks\Converter;

use League\CommonMark\Node\Block\Document;
use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\DocumentRendererInterface;
use ReflectionClass;
use ReflectionException;
use RoelMR\MarkdownToNotionBlocks\NotionBlocks\Image;
use RoelMR\MarkdownToNotionBlocks\Objects\NotionBlock;

final class NotionBlocksRenderer implements DocumentRendererInterface
{
    public function __construct(
        private readonly MarkdownImageProcessor $imageProcessor = new MarkdownImageProcessor(),
    ) {}

    /**
     * {@inheritDoc}
     *
     * @return NotionRenderedContent The rendered content.
     *
     * @throws ReflectionException
     */
    public function renderDocument(Document $document): NotionRenderedContent
    {
        $json = [];

        foreach ($document->children() as $node) {
            // Check for images within this node first (including links that are actually images)
            $images = $this->imageProcessor->extractImages($node);
            foreach ($images as $image) {
                $imageBlock = new Image($image);
                $json[] = $imageBlock->object();
            }

            $shortNameClass = (new ReflectionClass($node))->getShortName();

            // Run the block renderers dynamically.
            $class = 'RoelMR\\MarkdownToNotionBlocks\\NotionBlocks\\'.$shortNameClass;

            if (!class_exists($class)) {
                continue;
            }

            /* @var $class NotionBlock */
            $object = (new $class($node))->object();

            // Skip paragraphs that only contain images (we've already processed them above)
            if ($shortNameClass === 'Paragraph' && $this->imageProcessor->containsOnlyImages($node)) {
                continue;
            }

            $type = $object['type'] ?? '';

            /**
             * If `$object[<type>]['rich_text']` is more than 100 objects, split it into multiple objects.
             *
             * The Notion API only accepts 100 rich text objects per block.
             *
             * @since 1.2.0
             * @see https://developers.notion.com/reference/request-limits#limits-for-property-values
             */
            if (!isset($object[$type]['rich_text']) || count($object[$type]['rich_text']) <= 100) {
                $json[] = $object;

                continue;
            }

            $richText = $object[$type]['rich_text'];

            while (count($richText) > 100) {
                $object[$type]['rich_text'] = array_slice($richText, 0, 100);
                $json[] = $object;

                $richText = array_slice($richText, 100);
            }

            $object[$type]['rich_text'] = $richText;
            $json[] = $object;
        }

        /**
         * Some arrays within the final JSON are group of arrays.
         * This function will flatten them to a single array.
         *
         * Only the `ListBlock` and `TodoBlock` are affected by this
         * because Notion API wants the children array to be a single array.
         *
         * @since 1.0.0
         */
        $json = $this->flattenSpecificArray($json);

        /**
         * Notion API only accepts 100 blocks per request.
         *
         * If we don't chunk the array, the API will return a 400 error.
         *
         * @since 1.0.0
         */
        $json = array_chunk($json, 100);

        /**
         * Convert the array to JSON.
         *
         * We're using the `JSON_INVALID_UTF8_IGNORE` flag to ignore invalid UTF-8 characters.
         *
         * This is because some markdown files were triggering a syntax error.
         *
         * @since 1.2.2
         */
        $content = json_encode($json, JSON_INVALID_UTF8_IGNORE);

        return new NotionRenderedContent($document, $content);
    }

    /**
     * Flatten specific array.
     *
     * @since 1.0.0
     *
     * @param  array  $array  Array to flatten.
     * @return array Flattened array.
     */
    private function flattenSpecificArray(array $array): array
    {
        $result = [];

        foreach ($array as $element) {
            if (!is_array($element[0] ?? null)) {
                $result[] = $element;

                continue;
            }

            $result = array_merge($result, $element);
        }

        return $result;
    }
}
