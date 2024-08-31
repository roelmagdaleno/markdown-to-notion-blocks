<?php

namespace RoelMR\MarkdownToNotionBlocks\Objects;

use League\CommonMark\Extension\CommonMark\Node\Inline\Code;
use League\CommonMark\Extension\CommonMark\Node\Inline\Emphasis;
use League\CommonMark\Extension\CommonMark\Node\Inline\Strong;
use League\CommonMark\Extension\Strikethrough\Strikethrough;
use League\CommonMark\Node\Node;
use League\CommonMark\Node\StringContainerInterface;

class RichText {
    /**
     * The children nodes.
     *
     * @since 1.0.0
     *
     * @var array|iterable|Node[] The children nodes.
     */
    protected array $childNodes = [];

    /**
     * RichText constructor.
     *
     * @since 1.0.0
     *
     * @param Node $node The node.
     *
     * @see https://developers.notion.com/reference/rich-text
     */
    public function __construct(public Node $node) {
        $this->childNodes = $this->node->children();
    }

    /**
     * Get the rich text objects.
     * These are the objects that a rich text can have: text and annotations.
     *
     * @since 1.0.0
     *
     * @see https://developers.notion.com/reference/rich-text
     *
     * @return array The rich text objects.
     */
    protected function objects(): array {
        $objects = [];

        foreach ($this->childNodes as $node) {
            $object = $this->defaultObject();

            $object['text']['content'] = $this->getTextContent($node);
            $object['annotations'] = array_merge($object['annotations'], $this->getAnnotations($node));

            $objects[] = $object;
        }

        return $objects;
    }

    /**
     * Get the text content of a node.
     *
     * @since 1.0.0
     *
     * @param Node $node The node.
     * @return string The text content.
     */
    protected function getTextContent(Node $node): string {
        if ($node instanceof StringContainerInterface) {
            return $node->getLiteral();
        }

        if (!$node->hasChildren()) {
            return '';
        }

        $content = '';

        foreach ($node->children() as $child) {
            $content .= $this->getTextContent($child);
        }

        return $content;
    }

    /**
     * Get the annotations of a node.
     * These are the annotations that a node can have: bold, italic, strikethrough, and code.
     *
     * @since 1.0.0
     *
     * @param Node $node The node.
     * @return array The annotations.
     */
    protected function getAnnotations(Node $node): array {
        $annotations = [];

        // If `$node` is a strong node, set bold annotation to true.
        if ($node instanceof Strong) {
            $annotations['bold'] = true;
        }

        // If `$node` is an emphasis node, set italic annotation to true.
        if ($node instanceof Emphasis) {
            $annotations['italic'] = true;
        }

        // If `$node` is a strikethrough node, set strikethrough annotation to true.
        if ($node instanceof Strikethrough) {
            $annotations['strikethrough'] = true;
        }

        // If `$node` is a strikethrough node, set strikethrough annotation to true.
        if ($node instanceof Code) {
            $annotations['code'] = true;
        }

        if (!$node->hasChildren()) {
            return $annotations;
        }

        /**
         * If `$node` has children, iterate over them.
         *
         * This is useful for nested annotations.
         * For example, a strong node with an emphasis node inside.
         *
         * @since 1.0.0
         */
        foreach ($node->children() as $child) {
            $annotations = array_merge($annotations, $this->getAnnotations($child));
        }

        return $annotations;
    }

    /**
     * Get the default object.
     * The default object is a Notion object.
     *
     * @since 1.0.0
     *
     * @return array The default object.
     */
    protected function defaultObject(): array {
        return [
            'type' => 'text',
            'text' => [
                'content' => '',
                'link' => null,
            ],
            'annotations' => [
                'bold' => false,
                'italic' => false,
                'strikethrough' => false,
                'underline' => false,
                'code' => false,
                'color' => 'default',
            ],
        ];
    }

    /**
     * Convert the rich text to an array.
     *
     * @since 1.0.0
     *
     * @return array The rich text.
     */
    public function toArray(): array {
        return $this->node->hasChildren() ? $this->objects() : [];
    }
}
