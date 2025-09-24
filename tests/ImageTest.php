<?php

declare(strict_types=1);

use League\CommonMark\Extension\CommonMark\Node\Inline\Image as CommonMarkImage;
use League\CommonMark\Extension\CommonMark\Node\Inline\Link;
use RoelMR\MarkdownToNotionBlocks\NotionBlocks\Image;
use RoelMR\MarkdownToNotionBlocks\Objects\ImageLikeLink;

test('Image block with external URL generates correct Notion block', function () {
    $imageNode = new CommonMarkImage('https://example.com/image.jpg');
    $imageNode->setTitle('Alt text');
    $imageBlock = new Image($imageNode);

    $expected = [
        'object' => 'block',
        'type' => 'image',
        'image' => [
            'type' => 'external',
            'external' => [
                'url' => 'https://example.com/image.jpg',
            ],
            'caption' => [
                [
                    'type' => 'text',
                    'text' => [
                        'content' => 'Alt text',
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
    ];

    expect($imageBlock->object())->toBe($expected);
});

test('Image block with relative path generates file type', function () {
    $imageNode = new CommonMarkImage('./images/local-image.jpg');
    $imageNode->setTitle('Local image');
    $imageBlock = new Image($imageNode);

    $result = $imageBlock->object();

    expect($result['image']['type'])->toBe('file')
        ->and($result['image']['file']['url'])->toBe('./images/local-image.jpg');
});

test('Image block without title generates empty caption', function () {
    $imageNode = new CommonMarkImage('https://example.com/image.jpg');
    $imageBlock = new Image($imageNode);

    $result = $imageBlock->object();

    expect($result['image']['caption'])->toBe([]);
});

test('Image block with empty title generates empty caption', function () {
    $imageNode = new CommonMarkImage('https://example.com/image.jpg', '');
    $imageBlock = new Image($imageNode);

    $result = $imageBlock->object();

    expect($result['image']['caption'])->toBe([]);
});

test('Image block with ImageLikeLink generates correct block', function () {
    $link = new Link('https://example.com/image.jpg', 'Link Title');
    $imageLikeLink = new ImageLikeLink($link, 'Alt Text');
    $imageBlock = new Image($imageLikeLink);

    $expected = [
        'object' => 'block',
        'type' => 'image',
        'image' => [
            'type' => 'external',
            'external' => [
                'url' => 'https://example.com/image.jpg',
            ],
            'caption' => [
                [
                    'type' => 'text',
                    'text' => [
                        'content' => 'Alt Text',
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
    ];

    expect($imageBlock->object())->toBe($expected);
});

test('Image block differentiates between external and file URLs', function () {
    // Test external URL
    $externalImage = new CommonMarkImage('https://example.com/image.jpg', 'External');
    $externalBlock = new Image($externalImage);
    $externalResult = $externalBlock->object();

    expect($externalResult['image']['type'])->toBe('external')
        ->and($externalResult['image'])->toHaveKey('external')
        ->and($externalResult['image'])->not->toHaveKey('file');

    // Test file path
    $fileImage = new CommonMarkImage('local-image.jpg', 'Local');
    $fileBlock = new Image($fileImage);
    $fileResult = $fileBlock->object();

    expect($fileResult['image']['type'])->toBe('file')
        ->and($fileResult['image'])->toHaveKey('file')
        ->and($fileResult['image'])->not->toHaveKey('external');
});

test('Image block handles special characters in caption', function () {
    $title = 'Image with "quotes" & special chars <test>';
    $imageNode = new CommonMarkImage('https://example.com/image.jpg');
    $imageNode->setTitle($title);
    $imageBlock = new Image($imageNode);

    $result = $imageBlock->object();

    expect($result['image']['caption'][0]['text']['content'])->toBe($title);
});

test('Image block handles unicode characters in caption', function () {
    $title = 'Image with unicode: 🖼️ 中文 العربية';
    $imageNode = new CommonMarkImage('https://example.com/image.jpg');
    $imageNode->setTitle($title);
    $imageBlock = new Image($imageNode);

    $result = $imageBlock->object();

    expect($result['image']['caption'][0]['text']['content'])->toBe($title);
});

test('Image block caption has correct structure', function () {
    $imageNode = new CommonMarkImage('https://example.com/image.jpg');
    $imageNode->setTitle('Test caption');
    $imageBlock = new Image($imageNode);

    $result = $imageBlock->object();
    $caption = $result['image']['caption'][0];

    expect($caption)->toHaveKeys(['type', 'text', 'annotations'])
        ->and($caption['type'])->toBe('text')
        ->and($caption['text'])->toHaveKeys(['content', 'link'])
        ->and($caption['text']['link'])->toBeNull()
        ->and($caption['annotations'])->toHaveKeys([
            'bold',
            'italic',
            'strikethrough',
            'underline',
            'code',
            'color',
        ]);
});

test('Image block from full markdown integration', function () {
    $markdown = '![Alt text](https://example.com/image.jpg)';

    $expected = [
        'object' => 'block',
        'type' => 'image',
        'image' => [
            'type' => 'external',
            'external' => [
                'url' => 'https://example.com/image.jpg',
            ],
            'caption' => [],
        ],
    ];

    expect(convert($markdown))->toBe(expectedJson($expected));
});

test('Image block handles various URL formats', function () {
    $urls = [
        'https://example.com/image.jpg',
        'http://example.com/image.png',
        'https://cdn.example.com/path/to/image.gif?v=1&size=large',
        './images/local.jpg',
        '../assets/image.png',
        '/absolute/path/image.svg',
        'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mP8/5+hHgAHggJ/PchI7wAAAABJRU5ErkJggg==',
    ];

    foreach ($urls as $url) {
        $imageNode = new CommonMarkImage($url);
        $imageNode->setTitle('Test');
        $imageBlock = new Image($imageNode);
        $result = $imageBlock->object();

        $isExternal = filter_var($url, FILTER_VALIDATE_URL) !== false;
        $expectedType = $isExternal ? 'external' : 'file';

        expect($result['image']['type'])->toBe($expectedType)
            ->and($result['image'][$expectedType]['url'])->toBe($url);
    }
});
