<?php

test('a fenced code has the expected output', function () {
    $markdown = <<<MD
    ```php
    echo 'Hello, World!';
    ```
    MD;

    $expected = [
        'object' => 'block',
        'type' => 'code',
        'code' => [
            'caption' => [],
            'rich_text' => [
                [
                    'type' => 'text',
                    'text' => [
                        'content' => "echo 'Hello, World!';\n",
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
            'language' => 'php',
        ],
    ];

    expect(convert($markdown))->toBe(json_encode([$expected]));
});
