<?php

namespace RoelMR\MarkdownToNotionBlocks\NotionBlocks;

use League\CommonMark\Extension\CommonMark\Node\Block\FencedCode as CommonMarkFencedCode;
use RoelMR\MarkdownToNotionBlocks\Objects\NotionBlock;
use RoelMR\MarkdownToNotionBlocks\Objects\RichText;

class FencedCode extends NotionBlock {
    /**
     * Code constructor.
     *
     * @since 1.0.0
     *
     * @param CommonMarkFencedCode $node The code node.
     */
    public function __construct(public CommonMarkFencedCode $node) {}

    /**
     * @inheritDoc
     */
    public function object(): array {
        return array(
            'object' => 'block',
            'type' => 'code',
            'code' => array(
                'caption' => [],
                'rich_text' => $this->richText($this->node),
                'language' => $this->language(),
            ),
        );
    }

    /**
     * Get the language of the code block.
     *
     * Check the available languages in the Notion API documentation.
     *
     * @since 1.0.0
     *
     * @see https://developers.notion.com/reference/block#code
     *
     * @return string The language of the code block.
     */
    protected function language(): string {
        return $this->node->getInfo();
    }
}
