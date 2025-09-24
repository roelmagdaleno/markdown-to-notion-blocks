<?php

declare(strict_types=1);

namespace RoelMR\MarkdownToNotionBlocks\Converter;

use League\CommonMark\ConverterInterface;
use League\CommonMark\Environment\EnvironmentInterface;
use League\CommonMark\Exception\CommonMarkException;
use League\CommonMark\Output\RenderedContentInterface;
use League\CommonMark\Parser\MarkdownParser;
use League\CommonMark\Parser\MarkdownParserInterface;
use League\CommonMark\Renderer\DocumentRendererInterface;
use ReflectionException;

final class MarkdownToNotionBlocksConverter implements ConverterInterface
{
    private MarkdownParserInterface $parser;

    private DocumentRendererInterface $renderer;

    /**
     * MarkdownToNotionBlocksConverter constructor.
     *
     * @since 1.0.0
     *
     * @param  EnvironmentInterface  $environment  The CommonMark environment.
     */
    public function __construct(EnvironmentInterface $environment)
    {
        $this->parser = new MarkdownParser($environment);
        $this->renderer = new NotionBlocksRenderer;
    }

    /**
     * Convert markdown to Notion blocks.
     *
     * @since 1.0.0
     *
     * @param  string  $input  Markdown content.
     * @return RenderedContentInterface The Notion blocks from parsed markdown.
     *
     * @throws CommonMarkException
     * @throws ReflectionException
     */
    public function convert(string $input): RenderedContentInterface
    {
        return $this->renderer->renderDocument($this->parser->parse($input));
    }
}
