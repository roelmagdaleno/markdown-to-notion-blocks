<?php

namespace RoelMR\MarkdownToNotionBlocks\NotionBlocks;

use League\CommonMark\Node\Block\Paragraph as CommonMarkParagraph;
use RoelMR\MarkdownToNotionBlocks\Objects\NotionBlock;

class Paragraph extends NotionBlock {
    /**
     * Paragraph constructor.
     *
     * @since 1.0.0
     *
     * @param CommonMarkParagraph $node The paragraph node.
     *
     * @see https://developers.notion.com/reference/block#paragraph
     */
    public function __construct(public CommonMarkParagraph $node) {}

    /**
     * @inheritDoc
     */
    public function object(): array {
        return array(
            'object' => 'block',
            'type' => 'paragraph',
            'paragraph' => array(
                'rich_text' => $this->richText($this->node),
                'color' => $this->color(),
            ),
        );
    }

    /**
     * The color of the block.
     *
     * @since 1.0.0
     *
     * @return string The color of the block.
     */
    protected function color(): string {
        return 'default';
    }
}
