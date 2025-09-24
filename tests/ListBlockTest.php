<?php

declare(strict_types=1);

test('a bulleted list has the expected output', function () {
    $markdown = <<<'MD'
    - List 1
    - List 2
    MD;

    $expected = [
        [
            'object' => 'block',
            'type' => 'bulleted_list_item',
            'bulleted_list_item' => [
                'rich_text' => [
                    [
                        'type' => 'text',
                        'text' => [
                            'content' => 'List 1',
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
        ],
        [
            'object' => 'block',
            'type' => 'bulleted_list_item',
            'bulleted_list_item' => [
                'rich_text' => [
                    [
                        'type' => 'text',
                        'text' => [
                            'content' => 'List 2',
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
        ],
    ];

    expect(convert($markdown))->toBe(json_encode([$expected]));
});

test('an ordered list has the expected output', function () {
    $markdown = <<<'MD'
    1. Item 1
    2. Item 2
    MD;

    $expected = [
        [
            'object' => 'block',
            'type' => 'numbered_list_item',
            'numbered_list_item' => [
                'rich_text' => [
                    [
                        'type' => 'text',
                        'text' => [
                            'content' => 'Item 1',
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
        ],
        [
            'object' => 'block',
            'type' => 'numbered_list_item',
            'numbered_list_item' => [
                'rich_text' => [
                    [
                        'type' => 'text',
                        'text' => [
                            'content' => 'Item 2',
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
        ],
    ];

    expect(convert($markdown))->toBe(json_encode([$expected]));
});

test('a list with annotations', function () {
    $markdown = <<<'MD'
    - List **1**
    - List *2*
    MD;

    $expected = [
        [
            'object' => 'block',
            'type' => 'bulleted_list_item',
            'bulleted_list_item' => [
                'rich_text' => [
                    [
                        'type' => 'text',
                        'text' => [
                            'content' => 'List ',
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
                            'content' => '1',
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
                ],
                'color' => 'default',
            ],
        ],
        [
            'object' => 'block',
            'type' => 'bulleted_list_item',
            'bulleted_list_item' => [
                'rich_text' => [
                    [
                        'type' => 'text',
                        'text' => [
                            'content' => 'List ',
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
                            'content' => '2',
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
                ],
                'color' => 'default',
            ],
        ],
    ];

    expect(convert($markdown))->toBe(json_encode([$expected]));
});
