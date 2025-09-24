<?php

declare(strict_types=1);

namespace RoelMR\MarkdownToNotionBlocks\Objects;

use League\CommonMark\Node\Node;

abstract class NotionBlock
{
    /**
     * The object.
     *
     * The object is a JSON object that represents a Notion block.
     *
     * @since 1.0.0
     *
     * @return array The object.
     */
    abstract public function object(): array;

    /**
     * The rich text of the block.
     *
     * @since 1.0.0
     *
     * @param  Node|bool  $node  The node.
     * @return array The rich text of the block.
     */
    protected function richText(Node|bool $node): array
    {
        return $node instanceof Node ? (new RichText($node))->toArray() : [];
    }
}
