<?php

namespace RoelMR\MarkdownToNotionBlocks;

use League\CommonMark\Output\RenderedContent;

class NotionRenderedContent extends RenderedContent {
    /**
     * Get the JSON as an array.
     *
     * This method is handy when you want to edit content before using it in a Notion API request.
     *
     * @since 1.0.0
     *
     * @return array The JSON as an array.
     */
    public function toArray(): array {
        return json_decode($this->getContent(), true);
    }
}
