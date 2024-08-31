<?php

declare(strict_types=1);

namespace RoelMR\MarkdownToNotionBlocks;

use League\CommonMark\ConverterInterface;
use League\CommonMark\Environment\EnvironmentInterface;
use League\CommonMark\Output\RenderedContentInterface;
use League\CommonMark\Parser\MarkdownParser;
use League\CommonMark\Parser\MarkdownParserInterface;
use League\CommonMark\Renderer\DocumentRendererInterface;

class MarkdownToNotionBlocksConverter implements ConverterInterface {
    private MarkdownParserInterface $parser;
    private DocumentRendererInterface $renderer;

    public function __construct(EnvironmentInterface $environment) {
        $this->parser = new MarkdownParser($environment);
        $this->renderer = new NotionBlocksRenderer();
    }

    /**
     * @inheritDoc
     */
    public function convert(string $input): RenderedContentInterface {
        return $this->renderer->renderDocument($this->parser->parse($input));
    }
}
