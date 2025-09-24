<?php

declare(strict_types=1);

namespace RoelMR\MarkdownToNotionBlocks\NotionBlocks;

use League\CommonMark\Extension\CommonMark\Node\Block\ListBlock as CommonMarkListBlock;
use League\CommonMark\Extension\TaskList\TaskListItemMarker;
use League\CommonMark\Node\Node;
use RoelMR\MarkdownToNotionBlocks\Objects\NotionBlock;

final class ListBlock extends NotionBlock
{
    /**
     * Paragraph constructor.
     *
     * @since 1.0.0
     *
     * @param  CommonMarkListBlock  $node  The paragraph node.
     *
     * @see https://developers.notion.com/reference/block#bulleted-list-item
     * @see https://developers.notion.com/reference/block#numbered-list-item
     */
    public function __construct(public CommonMarkListBlock $node) {}

    /**
     * {@inheritDoc}
     */
    public function object(): array
    {
        $objects = [];
        $type = $this->node->getListData()->type === 'ordered' ? 'numbered_list_item' : 'bulleted_list_item';

        /**
         * According to Notion API responses, a list block can have multiple list items.
         * So, each list item is a block object. We need to iterate over each list item and convert it to a block object.
         *
         * @since 1.0.0
         */
        foreach ($this->node->children() as $listItem) {
            $isToDo = $this->isToDo($listItem);

            $objects[] = $isToDo ? (new TodoBlock($listItem))->object() : [
                'object' => 'block',
                'type' => $type,
                $type => [
                    'rich_text' => $this->richText($listItem->children()[0]),
                    'color' => $this->color(),
                ],
            ];
        }

        return $objects;
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
     * Check if the list item is a to-do item.
     *
     * @since 1.0.0
     *
     * @param  Node  $listItem  The list item node.
     * @return bool Whether the list item is a to-do item.
     */
    protected function isToDo(Node $listItem): bool
    {
        return $listItem->firstChild()?->firstChild() instanceof TaskListItemMarker;
    }
}
