<?php

declare(strict_types=1);

namespace RoelMR\MarkdownToNotionBlocks\NotionBlocks;

use Incenteev\EmojiPattern\EmojiPattern;
use League\CommonMark\Extension\CommonMark\Node\Block\BlockQuote as CommonMarkBlockQuote;
use League\CommonMark\Node\Inline\AbstractStringContainer;
use League\CommonMark\Node\Node;
use RoelMR\MarkdownToNotionBlocks\Objects\NotionBlock;
use RoelMR\MarkdownToNotionBlocks\Objects\RichText;

final class Callout extends NotionBlock
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
     * The type of the block.
     *
     * @since 1.0.0
     *
     * @var string The type of the block.
     */
    public string $type = 'NOTE';

    /**
     * The emoji of the block.
     *
     * @since 1.0.0
     *
     * @var string The emoji of the block.
     */
    public string $emoji = '';

    /**
     * Callout constructor.
     *
     * @since 1.0.0
     *
     * @param  CommonMarkBlockQuote  $node  The block quote node.
     *
     * @see https://developers.notion.com/reference/block#callout
     */
    public function __construct(public CommonMarkBlockQuote $node)
    {
        $this->realNode = !$node->hasChildren() ? false : $node->children()[0];

        if ($this->realNode) {
            $this->setProperties();
        }
    }

    /**
     * {@inheritDoc}
     */
    public function object(): array
    {
        return [
            'object' => 'block',
            'type' => 'callout',
            'callout' => [
                'rich_text' => $this->richText($this->realNode),
                'icon' => $this->icon(),
                'color' => $this->color(),
            ],
        ];
    }

    /**
     * {@inheritDoc}
     */
    protected function richText(Node|bool $node): array
    {
        $richText = (new RichText($node))->toArray();

        // Remove the entire object if the rich text first object is a line break.
        if ($richText[0]['type'] === 'text' && $richText[0]['text']['content'] === PHP_EOL) {
            array_shift($richText);
        }

        return $richText;
    }

    /**
     * The icon of the block.
     *
     * @since 1.0.0
     *
     * @return null|array The icon of the block.
     */
    protected function icon(): ?array
    {
        return empty($this->emoji) ? null : [
            'type' => 'emoji',
            'emoji' => $this->emoji,
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
        $backgroundColors = [
            'CAUTION' => 'yellow_background',
            'DANGER' => 'red_background',
            'IMPORTANT' => 'purple_background',
            'INFO' => 'blue_background',
            'NOTE' => 'blue_background',
            'SUCCESS' => 'green_background',
            'TIP' => 'green_background',
            'WARNING' => 'orange_background',
        ];

        return $backgroundColors[$this->type] ?? 'gray_background';
    }

    /**
     * Set the properties of the block.
     *
     * We're just setting the callout type and emoji.
     *
     * @since 1.0.0
     */
    protected function setProperties(): void
    {
        $firstChild = $this->realNode->firstChild();

        if (!$firstChild instanceof AbstractStringContainer) {
            return;
        }

        $textContent = mb_trim($firstChild->getLiteral());
        $pattern = '/\[!(\w+)](?:\s('.EmojiPattern::getEmojiPattern().'))?/mu';

        /**
         * Extract the callout type and emoji.
         *
         * The block quote must start with the callout type and emoji.
         * For example, if you want to create a note callout, you must start the block quote with `[!NOTE] ⛏️`.
         *
         * So, the format to write your callouts is: `[!TYPE] EMOJI`. *The EMOJI is optional*.
         *
         * @since 1.0.0
         */
        preg_match($pattern, $textContent, $matches);

        $this->type = empty($matches) ? $this->type : $matches[1] ?? 'NOTE';
        $this->emoji = empty($matches) ? $this->emoji : $matches[2] ?? '';

        // We don't need the callout type and emoji in the text content anymore.
        $textContent = mb_trim(preg_replace($pattern, '', $textContent));

        if ($textContent === '') {
            $firstChild->detach();

            return;
        }

        $firstChild->setLiteral($textContent);
    }
}
