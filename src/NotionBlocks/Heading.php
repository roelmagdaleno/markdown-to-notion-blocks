<?php

declare(strict_types=1);

namespace RoelMR\MarkdownToNotionBlocks\NotionBlocks;

use League\CommonMark\Extension\CommonMark\Node\Block\Heading as CommonMarkHeading;
use RoelMR\MarkdownToNotionBlocks\Objects\NotionBlock;

final class Heading extends NotionBlock
{
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
     * @param  CommonMarkHeading  $node  The heading node.
     */
    public function __construct(public CommonMarkHeading $node)
    {
        $level = $this->node->getLevel();
        $this->level = $level >= 4 ? 3 : $level; // Notion only supports up to h3.
    }

    /**
     * {@inheritDoc}
     */
    public function object(): array
    {
        $type = "heading_$this->level";

        return [
            'object' => 'block',
            'type' => $type,
            $type => [
                'rich_text' => $this->richText($this->node),
                'color' => $this->color(),
                'is_toggleable' => $this->isToggleable(),
            ],
        ];
    }

    /**
     * The color of the block.
     *
     * @since 1.0.0
     *
     * @return string The color of the block.
     */
    protected function color(): string
    {
        return 'default';
    }

    /**
     * Whether the block is toggleable or not.
     *
     * @since 1.0.0
     *
     * @return bool Whether the block is toggleable or not.
     */
    protected function isToggleable(): bool
    {
        return false;
    }
}
