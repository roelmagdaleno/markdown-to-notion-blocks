<?php

namespace RoelMR\MarkdownToNotionBlocks\Objects;

abstract class NotionBlock {
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
     * @return array The rich text of the block.
     */
    abstract protected function richText(): array;
}
