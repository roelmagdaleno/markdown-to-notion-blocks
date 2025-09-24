<?php

declare(strict_types=1);

test('a simple callout', function () {
    $markdown = <<<'MD'
    > [!NOTE] This is a callout.
    MD;

    $expected = [
        'object' => 'block',
        'type' => 'callout',
        'callout' => [
            'rich_text' => [
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
            'icon' => null,
            'color' => 'blue_background',
        ],
    ];

    expect(convert($markdown))->toBe(expectedJson($expected));
});

test('a simple callout with emoji', function () {
    $markdown = <<<'MD'
    > [!NOTE] ⛏️ This is a callout.
    MD;

    $expected = [
        'object' => 'block',
        'type' => 'callout',
        'callout' => [
            'rich_text' => [
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

    expect(convert($markdown))->toBe(expectedJson($expected));
});

test('a callout with title and body', function () {
    $markdown = <<<'MD'
    > [!NOTE] This is a callout title.
    > This is a callout body.
    MD;

    $expected = [
        'object' => 'block',
        'type' => 'callout',
        'callout' => [
            'rich_text' => [
                [
                    'type' => 'text',
                    'text' => [
                        'content' => 'This is a callout title.',
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
                        'content' => 'This is a callout body.',
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
            'icon' => null,
            'color' => 'blue_background',
        ],
    ];

    expect(convert($markdown))->toBe(expectedJson($expected));
});

test('a callout with title, body, and emoji', function () {
    $markdown = <<<'MD'
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

    expect(convert($markdown))->toBe(expectedJson($expected));
});

test('a callout with title, body, emoji, and annotations', function () {
    $markdown = <<<'MD'
    > [!NOTE] ⛏️ A **callout** title.
    > This is a *callout*.
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
                        'content' => 'This is a ',
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
            'icon' => [
                'type' => 'emoji',
                'emoji' => '⛏️',
            ],
            'color' => 'blue_background',
        ],
    ];

    expect(convert($markdown))->toBe(expectedJson($expected));
});

test('an empty callout', function () {
    $markdown = <<<'MD'
    > [!NOTE]
    MD;

    $expected = [
        'object' => 'block',
        'type' => 'callout',
        'callout' => [
            'rich_text' => [
                [
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
                ],
            ],
            'icon' => null,
            'color' => 'blue_background',
        ],
    ];

    expect(convert($markdown))->toBe(expectedJson($expected));
});

test('the first string in a callout with emoji is an annotation', function () {
    $markdown = <<<'MD'
    > [!NOTE] ⛏️ **This** is a callout.
    MD;

    $expected = [
        'object' => 'block',
        'type' => 'callout',
        'callout' => [
            'rich_text' => [
                [
                    'type' => 'text',
                    'text' => [
                        'content' => 'This',
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
                        'content' => ' is a callout.',
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

    expect(convert($markdown))->toBe(expectedJson($expected));
});

test('the first string in a callout without emoji is an annotation', function () {
    $markdown = <<<'MD'
    > [!NOTE] **This** is a callout.
    MD;

    $expected = [
        'object' => 'block',
        'type' => 'callout',
        'callout' => [
            'rich_text' => [
                [
                    'type' => 'text',
                    'text' => [
                        'content' => 'This',
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
                        'content' => ' is a callout.',
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
            'icon' => null,
            'color' => 'blue_background',
        ],
    ];

    expect(convert($markdown))->toBe(expectedJson($expected));
});
