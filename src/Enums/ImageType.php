<?php

declare(strict_types=1);

namespace RoelMR\MarkdownToNotionBlocks\Enums;

use RoelMR\MarkdownToNotionBlocks\Objects\RichText;

enum ImageType: string
{
    case INVALID = 'invalid';
    case EXTERNAL = 'external';
    case FILE = 'file';

    /**
     * Get the appropriate image block based on URL and title.
     *
     * @param  string  $url  The image URL
     * @param  string|null  $title  The image title
     * @return array The appropriate image block
     */
    public function get(string $url, ?string $title = null): array
    {
        if ($this === self::INVALID) {
            return $this->buildInvalidBlock($url);
        }

        return [
            'object' => 'block',
            'type' => 'image',
            'image' => [
                'type' => $this->value,
                $this->value => [
                    'url' => $url,
                ],
                'caption' => $this->caption($title),
            ],
        ];
    }

    /**
     * Return array structure for invalid image.
     *
     * @param  string  $url  The invalid image URL
     * @return array Paragraph block for invalid image
     */
    private function buildInvalidBlock(string $url): array
    {
        $richTextObject = array_replace_recursive(
            RichText::defaultObject(),
            [
                'text' => ['content' => '[Invalid image: '.$url.']'],
                'annotations' => ['italic' => true, 'color' => 'gray'],
            ]
        );

        return [
            'object' => 'block',
            'type' => 'paragraph',
            'paragraph' => [
                'rich_text' => [$richTextObject],
            ],
        ];
    }

    /**
     * Build caption array from title string.
     *
     * @param  string|null  $title  The image title
     * @return array The caption array for Notion
     */
    private function caption(?string $title): array
    {
        if (empty($title)) {
            return [];
        }

        $richTextObject = array_replace_recursive(
            RichText::defaultObject(),
            ['text' => ['content' => $title]]
        );

        return [$richTextObject];
    }
}
