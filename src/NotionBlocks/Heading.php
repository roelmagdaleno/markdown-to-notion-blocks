<?php

namespace RoelMR\MarkdownToNotionBlocks\NotionBlocks;

use League\CommonMark\Extension\CommonMark\Node\Block\Heading as CommonMarkHeading;
use RoelMR\MarkdownToNotionBlocks\Objects\NotionBlock;

class Heading extends NotionBlock {
    /**
     * The level of the heading.
     *
     * @since 1.0.0
     *
     * @var int The level of the heading.
     */
    public int $level;

    /**
     * Heading constructor.
     *
     * @since 1.0.0
     *
     * @param CommonMarkHeading $node The heading node.
     */
    public function __construct(public CommonMarkHeading $node) {
        $this->level = $this->node->getLevel();
    }

    /**
     * @inheritDoc
     */
    public function object(): array {
        $type = "heading_$this->level";

        return array(
            'object' => 'block',
            'type' => $type,
            $type => array(
                'rich_text' => $this->richText($this->node),
                'color' => $this->color(),
                'is_toggleable' => $this->isToggleable(),
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

    /**
     * Whether the block is toggleable or not.
     *
     * @since 1.0.0
     *
     * @return bool Whether the block is toggleable or not.
     */
    protected function isToggleable(): bool {
        return false;
    }
}
