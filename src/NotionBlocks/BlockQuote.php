<?php

declare(strict_types=1);

namespace RoelMR\MarkdownToNotionBlocks\NotionBlocks;

use League\CommonMark\Extension\CommonMark\Node\Block\BlockQuote as CommonMarkBlockQuote;
use League\CommonMark\Node\Inline\AbstractStringContainer;
use League\CommonMark\Node\Node;
use RoelMR\MarkdownToNotionBlocks\Objects\NotionBlock;

final class BlockQuote extends NotionBlock
{
    /**
     * The real node.
     *
     * A real node is the first child node of the block quote node.
     * That first child node includes all the children nodes of the block quote node.
     *
     * @since 1.0.0
     *
     * @var false|Node The real node.
     */
    public false|Node $realNode;

    /**
     * Block quote constructor.
     *
     * @since 1.0.0
     *
     * @param  CommonMarkBlockQuote  $node  The block quote node.
     *
     * @see https://developers.notion.com/reference/block#quote
     */
    public function __construct(public CommonMarkBlockQuote $node)
    {
        $this->realNode = !$node->hasChildren() ? false : $node->children()[0];
    }

    /**
     * {@inheritDoc}
     */
    public function object(): array
    {
        return $this->isCallout()
            ? (new Callout($this->node))->object()
            : [
                'object' => 'block',
                'type' => 'quote',
                'quote' => [
                    'rich_text' => $this->richText($this->realNode),
                    'color' => $this->color(),
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
     * Check if the block quote is a callout.
     * The first child of the node must have a callout type.
     *
     * See `$types` variable for the callout types.
     *
     * @since 1.0.0
     *
     * @return bool True if the block quote is a callout, false otherwise.
     */
    protected function isCallout(): bool
    {
        if (!$this->realNode) {
            return false;
        }

        $types = [
            '[!NOTE]',
            '[!TIP]',
            '[!SUCCESS]',
            '[!IMPORTANT]',
            '[!WARNING]',
            '[!DANGER]',
            '[!CAUTION]',
        ];

        $firstChild = $this->realNode->firstChild();

        if (!$firstChild instanceof AbstractStringContainer) {
            return false;
        }

        $textContent = mb_strtolower($firstChild->getLiteral());
        $callout = array_filter($types, fn ($type) => str_contains($textContent, mb_strtolower($type)));

        return !empty($callout);
    }
}
