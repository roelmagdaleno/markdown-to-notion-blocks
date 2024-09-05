<?php

namespace RoelMR\MarkdownToNotionBlocks\NotionBlocks;

use League\CommonMark\Extension\CommonMark\Node\Block\ListBlock as CommonMarkListBlock;
use RoelMR\MarkdownToNotionBlocks\Objects\NotionBlock;

class ListBlock extends NotionBlock {
    /**
     * Paragraph constructor.
     *
     * @since 1.0.0
     *
     * @param CommonMarkListBlock $node The paragraph node.
     *
     * @see https://developers.notion.com/reference/block#paragraph
     */
    public function __construct(public CommonMarkListBlock $node) {}

    /**
     * @inheritDoc
     */
    public function object(): array {
        $objects = [];
        $type = $this->node->getListData()->type === 'ordered' ? 'numbered_list_item' : 'bulleted_list_item';

        /**
         * According to Notion API responses, a list block can have multiple list items.
         * So, each list item is a block object. We need to iterate over each list item and convert it to a block object.
         *
         * @since 1.0.0
         */
        foreach ($this->node->children() as $listItem) {
            $objects[] = array(
                'object' => 'block',
                'type' => $type,
                $type => array(
                    'rich_text' => $this->richText($listItem->children()[0]),
                    'color' => $this->color(),
                ),
            );
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
    protected function color(): string {
        return 'default';
    }
}
