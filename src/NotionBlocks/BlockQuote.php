<?php

namespace RoelMR\MarkdownToNotionBlocks\NotionBlocks;

use League\CommonMark\Extension\CommonMark\Node\Block\BlockQuote as CommonMarkBlockQuote;
use RoelMR\MarkdownToNotionBlocks\Objects\NotionBlock;
use RoelMR\MarkdownToNotionBlocks\Objects\RichText;

class BlockQuote extends NotionBlock {
    /**
     * Block quote constructor.
     *
     * @since 1.0.0
     *
     * @param CommonMarkBlockQuote $node The block quote node.
     *
     * @see https://developers.notion.com/reference/block#quote
     */
    public function __construct(public CommonMarkBlockQuote $node) {}

    /**
     * @inheritDoc
     */
    public function object(): array {
        return array(
            'object' => 'block',
            'type' => 'quote',
            'quote' => array(
                'rich_text' => $this->richText(),
                'color' => $this->color(),
            ),
        );
    }

    /**
     * @inheritDoc
     */
    protected function richText(): array {
        if (!$this->node->hasChildren()) {
            return [];
        }

        $node = $this->node->children();

        // For the BlockQuote, all children nodes live in the first child node.
        return (new RichText($node[0]))->toArray();
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
