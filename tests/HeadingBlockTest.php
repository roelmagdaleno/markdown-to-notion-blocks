<?php

test('a heading level one has the expected output', function () {
    $markdown = <<<MD
    # My main heading
    MD;

    $expected = [
        'object' => 'block',
        'type' => 'heading_1',
        'heading_1' => [
            'rich_text' => [
                [
                    'type' => 'text',
                    'text' => [
                        'content' => 'My main heading',
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
            'is_toggleable' => false,
        ],
    ];

    expect(convert($markdown))->toBe(json_encode([$expected]));
});

test('a heading level two has the expected output', function () {
    $markdown = <<<MD
    ## My main heading
    MD;

    $expected = [
        'object' => 'block',
        'type' => 'heading_2',
        'heading_2' => [
            'rich_text' => [
                [
                    'type' => 'text',
                    'text' => [
                        'content' => 'My main heading',
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
            'is_toggleable' => false,
        ],
    ];

    expect(convert($markdown))->toBe(json_encode([$expected]));
});
