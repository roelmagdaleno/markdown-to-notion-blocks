<?php

declare(strict_types=1);

namespace RoelMR\MarkdownToNotionBlocks;

use League\CommonMark\Node\Block\Document;
use League\CommonMark\Output\RenderedContent;
use League\CommonMark\Output\RenderedContentInterface;
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

        return new NotionRenderedContent($document, json_encode($json));
    }
}
