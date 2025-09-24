<?php

declare(strict_types=1);

namespace RoelMR\MarkdownToNotionBlocks\NotionBlocks;

use League\CommonMark\Extension\CommonMark\Node\Inline\Image as CommonMarkImage;
use RoelMR\MarkdownToNotionBlocks\Enums\ImageType;
use RoelMR\MarkdownToNotionBlocks\Objects\ImageLikeLink;
use RoelMR\MarkdownToNotionBlocks\Objects\NotionBlock;
use RoelMR\MarkdownToNotionBlocks\Validators\ImageValidator;

final class Image extends NotionBlock
{
    private ImageValidator $validator;

    /**
     * Image constructor.
     *
     * @since 1.0.0
     *
     * @param  CommonMarkImage|ImageLikeLink  $node  The image node.
     *
     * @see https://developers.notion.com/reference/block#image
     */
    public function __construct(public CommonMarkImage|ImageLikeLink $node)
    {
        $this->validator = new ImageValidator;
    }

    /**
     * {@inheritDoc}
     */
    public function object(): array
    {
        $url = $this->node->getUrl();

        if (!$this->isValid()) {
            return ImageType::INVALID->get($url);
        }

        $title = $this->node->getTitle();

        if ($this->validator->isExternalUrl($url)) {
            return ImageType::EXTERNAL->get($url, $title);
        }

        return ImageType::FILE->get($url, $title);
    }

    /**
     * Check if the image is valid for Notion.
     *
     * @since 1.0.0
     *
     * @return bool True if the image is valid, false otherwise.
     */
    private function isValid(): bool
    {
        return $this->validator->isValidNotionImage($this->node->getUrl());
    }
}
