<?php

declare(strict_types=1);

test('a to do list has the expected output', function () {
    $markdown = <<<'MD'
    - [ ] Task 1
    - [ ] Task 2
    MD;

    $expected = [
        [
            'object' => 'block',
            'type' => 'to_do',
            'to_do' => [
                'color' => 'default',
                'checked' => false,
                'rich_text' => [
                    [
                        'type' => 'text',
                        'text' => [
                            'content' => 'Task 1',
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
            ],
        ],
        [
            'object' => 'block',
            'type' => 'to_do',
            'to_do' => [
                'color' => 'default',
                'checked' => false,
                'rich_text' => [
                    [
                        'type' => 'text',
                        'text' => [
                            'content' => 'Task 2',
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
            ],
        ],
    ];

    expect(convert($markdown))->toBe(json_encode([$expected]));
});

test('a to do list with annotations', function () {
    $markdown = <<<'MD'
    - [ ] Task **1**
    - [ ] Task *2*
    MD;

    $expected = [
        [
            'object' => 'block',
            'type' => 'to_do',
            'to_do' => [
                'color' => 'default',
                'checked' => false,
                'rich_text' => [
                    [
                        'type' => 'text',
                        'text' => [
                            'content' => 'Task',
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
            ],
        ],
        [
            'object' => 'block',
            'type' => 'to_do',
            'to_do' => [
                'color' => 'default',
                'checked' => false,
                'rich_text' => [
                    [
                        'type' => 'text',
                        'text' => [
                            'content' => 'Task',
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
            ],
        ],
    ];

    expect(convert($markdown))->toBe(json_encode([$expected]));
});

test('a to do list with link', function () {
    $markdown = <<<'MD'
    - [ ] Task 1
    - [ ] Task [2](https://commonmark.thephpleague.com/)
    MD;

    $expected = [
        [
            'object' => 'block',
            'type' => 'to_do',
            'to_do' => [
                'color' => 'default',
                'checked' => false,
                'rich_text' => [
                    [
                        'type' => 'text',
                        'text' => [
                            'content' => 'Task 1',
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
            ],
        ],
        [
            'object' => 'block',
            'type' => 'to_do',
            'to_do' => [
                'color' => 'default',
                'checked' => false,
                'rich_text' => [
                    [
                        'type' => 'text',
                        'text' => [
                            'content' => 'Task',
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
                ],
            ],
        ],
    ];

    expect(convert($markdown))->toBe(json_encode([$expected]));
});
