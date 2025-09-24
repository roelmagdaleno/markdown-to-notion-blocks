<?php

declare(strict_types=1);

test('a fenced code has the expected output', function () {
    $markdown = <<<'MD'
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
                        'content' => "echo 'Hello, World!';",
                        'link' => null,
                    ],
                ],
            ],
            'language' => 'php',
        ],
    ];

    expect(convert($markdown))->toBe(expectedJson($expected));
});

test('a fenced code has an invalid language', function () {
    $markdown = <<<'MD'
    ```invalid
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
                        'content' => "echo 'Hello, World!';",
                        'link' => null,
                    ],
                ],
            ],
            'language' => 'plain text',
        ],
    ];

    expect(convert($markdown))->toBe(expectedJson($expected));
});

test('a fenced code block with more than 1950 characters is split into multiple rich text objects', function () {
    // Generate a code string that's over 1950 characters
    $longCode = str_repeat('echo "This is a very long line of code that will be repeated many times to exceed the 1950 character limit. ";'.PHP_EOL, 30);

    $markdown = <<<MD
```php
{$longCode}```
MD;

    $result = convert($markdown);
    $converted = json_decode($result, true);

    // Debug: Check if we have a valid result
    expect($converted)->toBeArray();
    expect($converted)->not->toBeEmpty();

    // The result is wrapped in double arrays
    $blocks = $converted[0];
    expect($blocks)->toBeArray();
    expect($blocks)->not->toBeEmpty();

    // Verify it's a code block
    expect($blocks[0]['type'])->toBe('code');

    // Get the rich text array
    $richText = $blocks[0]['code']['rich_text'];

    // Verify we have multiple rich text objects
    expect(count($richText))->toBeGreaterThan(1);

    // Verify each rich text object has content <= 1950 characters
    foreach ($richText as $textObject) {
        expect(mb_strlen($textObject['text']['content']))->toBeLessThanOrEqual(1950);
    }

    // Verify the total content matches the original (minus any trimming)
    $totalContent = '';
    foreach ($richText as $textObject) {
        $totalContent .= $textObject['text']['content'];
    }
    expect(mb_trim($totalContent))->toBe(mb_trim($longCode));
});

test('a fenced code block with exactly 1951 characters is split correctly', function () {
    // Create a string that's exactly 1951 characters
    $codeContent = str_repeat('a', 1951);

    $markdown = <<<MD
```python
$codeContent
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
                        'content' => str_repeat('a', 1950),
                        'link' => null,
                    ],
                ],
                [
                    'type' => 'text',
                    'text' => [
                        'content' => 'a',
                        'link' => null,
                    ],
                ],
            ],
            'language' => 'python',
        ],
    ];

    expect(convert($markdown))->toBe(expectedJson($expected));
});
