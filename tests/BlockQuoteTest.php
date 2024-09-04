<?php

test('a block quote has the expected output', function () {
    $markdown = <<<MD
    > A simple block quote.
    MD;

    $expected = [
        'object' => 'block',
        'type' => 'quote',
        'quote' => [
            'rich_text' => [
                [
                    'type' => 'text',
                    'text' => [
                        'content' => 'A simple block quote.',
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
                ],
            ],
            'color' => 'default',
        ],
    ];

    expect(convert($markdown))->toBe(json_encode([$expected]));
});

test('a block quote has some annotations', function () {
    $markdown = <<<MD
    > This is my *text* with ~~some~~ **annotations**.
    > My second block **quote**.
    MD;

    $expected = [
        'object' => 'block',
        'type' => 'quote',
        'quote' => [
            'rich_text' => [
                [
                    'type' => 'text',
                    'text' => [
                        'content' => 'This is my ',
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
                ],
                [
                    'type' => 'text',
                    'text' => [
                        'content' => 'text',
                        'link' => null,
                    ],
                    'annotations' => [
                        'bold' => false,
                        'italic' => true,
                        'strikethrough' => false,
                        'underline' => false,
                        'code' => false,
                        'color' => 'default',
                    ],
                ],
                [
                    'type' => 'text',
                    'text' => [
                        'content' => ' with ',
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
                ],
                [
                    'type' => 'text',
                    'text' => [
                        'content' => 'some',
                        'link' => null,
                    ],
                    'annotations' => [
                        'bold' => false,
                        'italic' => false,
                        'strikethrough' => true,
                        'underline' => false,
                        'code' => false,
                        'color' => 'default',
                    ],
                ],
                [
                    'type' => 'text',
                    'text' => [
                        'content' => ' ',
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
                ],
                [
                    'type' => 'text',
                    'text' => [
                        'content' => 'annotations',
                        'link' => null,
                    ],
                    'annotations' => [
                        'bold' => true,
                        'italic' => false,
                        'strikethrough' => false,
                        'underline' => false,
                        'code' => false,
                        'color' => 'default',
                    ],
                ],
                [
                    'type' => 'text',
                    'text' => [
                        'content' => '.',
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
                ],
                [
                    'type' => 'text',
                    'text' => [
                        'content' => "\n",
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
                ],
                [
                    'type' => 'text',
                    'text' => [
                        'content' => 'My second block ',
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
                ],
                [
                    'type' => 'text',
                    'text' => [
                        'content' => 'quote',
                        'link' => null,
                    ],
                    'annotations' => [
                        'bold' => true,
                        'italic' => false,
                        'strikethrough' => false,
                        'underline' => false,
                        'code' => false,
                        'color' => 'default',
                    ],
                ],
                [
                    'type' => 'text',
                    'text' => [
                        'content' => '.',
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
                ],
            ],
            'color' => 'default',
        ],
    ];

    expect(convert($markdown))->toBe(json_encode([$expected]));
});

test('a block quote has empty content', function () {
    $markdown = <<<MD
    > 
    MD;

    $expected = [
        'object' => 'block',
        'type' => 'quote',
        'quote' => [
            'rich_text' => [],
            'color' => 'default',
        ],
    ];

    expect(convert($markdown))->toBe(json_encode([$expected]));
});

test('a block quote is a callout with emoji', function () {
    $markdown = <<<MD
    > [!NOTE] ⛏️ A callout title.
    > This is a callout.
    MD;

    $expected = [
        'object' => 'block',
        'type' => 'callout',
        'callout' => [
            'rich_text' => [
                [
                    'type' => 'text',
                    'text' => [
                        'content' => 'A callout title.',
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
                ],
                [
                    'type' => 'text',
                    'text' => [
                        'content' => PHP_EOL,
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
                ],
                [
                    'type' => 'text',
                    'text' => [
                        'content' => 'This is a callout.',
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
                ],
            ],
            'icon' => [
                'type' => 'emoji',
                'emoji' => '⛏️',
            ],
            'color' => 'blue_background',
        ],
    ];

    expect(convert($markdown))->toBe(json_encode([$expected]));
});

test('a block quote is a callout without emoji and annotations', function () {
    $markdown = <<<MD
    > [!NOTE] A **callout** title.
    > This is a callout.
    MD;

    $expected = [
        'object' => 'block',
        'type' => 'callout',
        'callout' => [
            'rich_text' => [
                [
                    'type' => 'text',
                    'text' => [
                        'content' => 'A',
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
                ],
                [
                    'type' => 'text',
                    'text' => [
                        'content' => 'callout',
                        'link' => null,
                    ],
                    'annotations' => [
                        'bold' => true,
                        'italic' => false,
                        'strikethrough' => false,
                        'underline' => false,
                        'code' => false,
                        'color' => 'default',
                    ],
                ],
                [
                    'type' => 'text',
                    'text' => [
                        'content' => ' title.',
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
                ],
                [
                    'type' => 'text',
                    'text' => [
                        'content' => PHP_EOL,
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
                ],
                [
                    'type' => 'text',
                    'text' => [
                        'content' => 'This is a callout.',
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
                ],
            ],
            'icon' => [
                'type' => 'emoji',
                'emoji' => '',
            ],
            'color' => 'blue_background',
        ],
    ];

    expect(convert($markdown))->toBe(json_encode([$expected]));
});

test('a block quote is a callout without emoji and full annotations', function () {
    $markdown = <<<MD
    > [!NOTE] **A** callout title.
    > This is a callout.
    MD;

    // @TODO Test with first text with annotation. It's failing right now.
});
