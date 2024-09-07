<?php

namespace RoelMR\MarkdownToNotionBlocks;

use League\CommonMark\Environment\Environment;
use League\CommonMark\Exception\CommonMarkException;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\GithubFlavoredMarkdownExtension;
use League\CommonMark\Output\RenderedContentInterface;
use League\Config\Exception\ConfigurationExceptionInterface;
use RoelMR\MarkdownToNotionBlocks\Converter\MarkdownToNotionBlocksConverter;
use RoelMR\MarkdownToNotionBlocks\Converter\NotionRenderedContent;

class MarkdownToNotionBlocks {
    /**
     * Convert markdown to Notion blocks in JSON format.
     *
     * @since 1.0.0
     *
     * @param string $markdown Markdown content.
     * @return string The Notion blocks from parsed markdown in JSON string.
     * @throws CommonMarkException
     * @throws ConfigurationExceptionInterface
     */
    public static function json(string $markdown): string {
        return self::convert($markdown)->getContent();
    }

    /**
     * Convert markdown to Notion blocks in array format.
     *
     * @since 1.0.0
     *
     * @param string $markdown Markdown content.
     * @return array The Notion blocks from parsed markdown in array format.
     * @throws CommonMarkException
     * @throws ConfigurationExceptionInterface
     */
    public static function array(string $markdown): array {
        return self::convert($markdown)->toArray();
    }

    /**
     * Convert markdown to Notion blocks.
     *
     * @since 1.0.0
     *
     * @param string $markdown Markdown content.
     * @return NotionRenderedContent The Notion blocks from parsed markdown.
     * @throws CommonMarkException
     * @throws ConfigurationExceptionInterface
     */
    protected static function convert(string $markdown): NotionRenderedContent {
        $environment = new Environment();
        $environment->addExtension(new CommonMarkCoreExtension());
        $environment->addExtension(new GithubFlavoredMarkdownExtension());

        $converter = new MarkdownToNotionBlocksConverter($environment);

        return $converter->convert($markdown);
    }
}
