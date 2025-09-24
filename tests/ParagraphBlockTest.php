<?php

declare(strict_types=1);

test('a paragraph has the expected output', function () {
    $markdown = <<<'MD'
    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
    MD;

    $expected = [
        'object' => 'block',
        'type' => 'paragraph',
        'paragraph' => [
            'rich_text' => [
                [
                    'type' => 'text',
                    'text' => [
                        'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
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

test('a paragraph with link', function () {
    $markdown = <<<'MD'
    Lorem ipsum dolor sit amet, [consectetur](https://commonmark.thephpleague.com/) adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
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
                        'link' => [
                            'url' => 'https://commonmark.thephpleague.com/',
                        ],
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

test('a paragraph with link and annotations', function () {
    $markdown = <<<'MD'
    Lorem ipsum dolor sit amet, **_[consectetur](https://commonmark.thephpleague.com/)_** adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
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
                        'link' => [
                            'url' => 'https://commonmark.thephpleague.com/',
                        ],
                    ],
                    'annotations' => [
                        'bold' => true,
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
