<?php

namespace RoelMR\MarkdownToNotionBlocks\Converter;

use League\CommonMark\Node\Block\Document;
use League\CommonMark\Renderer\DocumentRendererInterface;
use ReflectionClass;
use ReflectionException;
use RoelMR\MarkdownToNotionBlocks\Objects\NotionBlock;

class NotionBlocksRenderer implements DocumentRendererInterface {
    /**
     * @inheritDoc
     *
     * @return NotionRenderedContent The rendered content.
     * @throws ReflectionException
     */
    public function renderDocument(Document $document): NotionRenderedContent {
        $json = array();

        foreach ($document->children() as $node) {
            $shortNameClass = (new ReflectionClass($node))->getShortName();

            // Run the block renderers dynamically.
            $class = 'RoelMR\\MarkdownToNotionBlocks\\NotionBlocks\\' . $shortNameClass;

            if (!class_exists($class)) {
                continue;
            }

            /* @var $class NotionBlock */
            $json[] = (new $class($node))->object();
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

        return new NotionRenderedContent($document, json_encode($json));
    }

    /**
     * Flatten specific array.
     *
     * @since 1.0.0
     *
     * @param array $array Array to flatten.
     * @return array Flattened array.
     */
    protected function flattenSpecificArray(array $array): array {
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
