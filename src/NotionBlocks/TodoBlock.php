<?php

declare(strict_types=1);

namespace RoelMR\MarkdownToNotionBlocks\NotionBlocks;

use League\CommonMark\Extension\CommonMark\Node\Block\ListItem;
use League\CommonMark\Extension\TaskList\TaskListItemMarker;
use League\CommonMark\Node\Inline\Text;
use RoelMR\MarkdownToNotionBlocks\Objects\NotionBlock;

final class TodoBlock extends NotionBlock
{
    /**
     * Paragraph constructor.
     *
     * @since 1.0.0
     *
     * @param  ListItem  $node  The list item node.
     *
     * @see https://developers.notion.com/reference/block#to-do
     */
    public function __construct(public ListItem $node) {}

    /**
     * {@inheritDoc}
     */
    public function object(): array
    {
        $object = [
            'object' => 'block',
            'type' => 'to_do',
            'to_do' => [
                'color' => $this->color(),
            ],
        ];

        $taskListItem = $this->node->firstChild()?->firstChild();

        if (!$taskListItem instanceof TaskListItemMarker) {
            return $object;
        }

        $object['to_do']['checked'] = $taskListItem->isChecked();

        /**
         * The first child is the raw text of the list item.
         * And it's getting an extra space at the beginning.
         * So, we need to trim it.
         *
         * @since 1.0.0
         *
         * @var Text $rawText
         */
        $rawText = $this->node->children()[0]?->children()[1];
        $rawText->setLiteral(mb_trim($rawText->getLiteral()));

        // Detach the `TaskListItemMarker` node from the list item to avoid empty rich text results.
        $taskListItem->detach();

        $object['to_do']['rich_text'] = $this->richText($this->node->children()[0]);

        return $object;
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
}
