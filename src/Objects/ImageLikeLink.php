<?php

declare(strict_types=1);

namespace RoelMR\MarkdownToNotionBlocks\Objects;

use League\CommonMark\Extension\CommonMark\Node\Inline\Link;

/**
 * A wrapper to treat Link nodes that are actually images as Image nodes.
 */
final class ImageLikeLink
{
    public function __construct(private Link $link, private string $altText) {}

    public function getUrl(): string
    {
        return $this->link->getUrl();
    }

    public function getTitle(): ?string
    {
        return $this->altText ?: $this->link->getTitle();
    }
}
