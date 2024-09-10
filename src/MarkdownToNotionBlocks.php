<?php

namespace RoelMR\MarkdownToNotionBlocks;

use League\CommonMark\Environment\Environment;
use League\CommonMark\Exception\CommonMarkException;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\GithubFlavoredMarkdownExtension;
use League\CommonMark\Output\RenderedContentInterface;
use ReflectionException;
use RoelMR\MarkdownToNotionBlocks\Converter\MarkdownToNotionBlocksConverter;

class MarkdownToNotionBlocks {
    /**
     * Convert markdown to Notion blocks in JSON format.
     *
     * @param string $markdown Markdown content.
     *
     * @return string The Notion blocks from parsed markdown in JSON string.
     * @throws CommonMarkException|ReflectionException
     */
    public static function json(string $markdown): string {
        return self::convert($markdown)->getContent();
    }

    /**
     * Convert markdown to Notion blocks in array format.
     *
     * @param string $markdown Markdown content.
     *
     * @return array The Notion blocks from parsed markdown in array format.
     * @throws CommonMarkException|ReflectionException
     */
    public static function array(string $markdown): array {
        return json_decode(self::convert($markdown)->getContent(), true);
    }

    /**
     * Convert markdown to Notion blocks.
     *
     * @since 1.0.0
     *
     * @param string $markdown Markdown content.
     * @return RenderedContentInterface The Notion blocks from parsed markdown.
     * @throws CommonMarkException
     * @throws ReflectionException
     */
    public static function convert(string $markdown): RenderedContentInterface {
        $environment = new Environment();
        $environment->addExtension(new CommonMarkCoreExtension());
        $environment->addExtension(new GithubFlavoredMarkdownExtension());

        $converter = new MarkdownToNotionBlocksConverter($environment);

        return $converter->convert($markdown);
    }
}
