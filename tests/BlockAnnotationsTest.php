<?php

declare(strict_types=1);

test('a paragraph has bold annotation', function () {
    $markdown = <<<'MD'
    Lorem ipsum dolor sit amet, **consectetur** adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
    MD;

    $expected = [
        'object' => 'block',
        'type' => 'paragraph',
        'paragraph' => [
            'rich_text' => [
                [
                    'type' => 'text',
                    'text' => [
                        'content' => 'Lorem ipsum dolor sit amet, ',
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
                        'content' => 'consectetur',
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
                        'content' => ' adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
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

    expect(convert($markdown))->toBe(expectedJson($expected));
});

test('a paragraph has code annotation', function () {
    $markdown = <<<'MD'
    Lorem ipsum dolor sit amet, `consectetur` adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
    MD;

    $expected = [
        'object' => 'block',
        'type' => 'paragraph',
        'paragraph' => [
            'rich_text' => [
                [
                    'type' => 'text',
                    'text' => [
                        'content' => 'Lorem ipsum dolor sit amet, ',
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
                        'content' => 'consectetur',
                        'link' => null,
                    ],
                    'annotations' => [
                        'bold' => false,
                        'italic' => false,
                        'strikethrough' => false,
                        'underline' => false,
                        'code' => true,
                        'color' => 'red',
                    ],
                ],
                [
                    'type' => 'text',
                    'text' => [
                        'content' => ' adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
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

    expect(convert($markdown))->toBe(expectedJson($expected));
});

test('a paragraph has a strikethrough annotation', function () {
    $markdown = <<<'MD'
    Lorem ipsum dolor sit amet, ~~adipiscing elit~~, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
    MD;

    $expected = [
        'object' => 'block',
        'type' => 'paragraph',
        'paragraph' => [
            'rich_text' => [
                [
                    'type' => 'text',
                    'text' => [
                        'content' => 'Lorem ipsum dolor sit amet, ',
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
                        'content' => 'adipiscing elit',
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
                        'content' => ', sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
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

    expect(convert($markdown))->toBe(expectedJson($expected));
});

test('a paragraph has a italic annotation', function () {
    $markdown = <<<'MD'
    Lorem ipsum dolor sit amet, *adipiscing elit*, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
    MD;

    $expected = [
        'object' => 'block',
        'type' => 'paragraph',
        'paragraph' => [
            'rich_text' => [
                [
                    'type' => 'text',
                    'text' => [
                        'content' => 'Lorem ipsum dolor sit amet, ',
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
                        'content' => 'adipiscing elit',
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
                        'content' => ', sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
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

    expect(convert($markdown))->toBe(json_encode([[$expected]]));
});
