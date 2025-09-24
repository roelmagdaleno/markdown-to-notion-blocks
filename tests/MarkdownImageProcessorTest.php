<?php

declare(strict_types=1);

use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\CommonMark\Node\Inline\Image;
use League\CommonMark\Node\Block\Paragraph;
use League\CommonMark\Parser\MarkdownParser;
use RoelMR\MarkdownToNotionBlocks\Converter\MarkdownImageProcessor;

test('extractImages extracts image nodes from document', function () {
    $processor = new MarkdownImageProcessor();

    $environment = new Environment();
    $environment->addExtension(new CommonMarkCoreExtension());
    $parser = new MarkdownParser($environment);

    $markdown = '![Alt text](https://example.com/image.jpg)';
    $document = $parser->parse($markdown);

    $images = $processor->extractImages($document);

    expect($images)->toHaveCount(1)
        ->and($images[0])->toBeInstanceOf(Image::class)
        ->and($images[0]->getUrl())->toBe('https://example.com/image.jpg');
});

test('extractImages extracts image-like links from document', function () {
    $processor = new MarkdownImageProcessor();

    $environment = new Environment();
    $environment->addExtension(new CommonMarkCoreExtension());
    $parser = new MarkdownParser($environment);

    $markdown = '![Alt text](https://example.com/image.jpg "Title")';
    $document = $parser->parse($markdown);

    $images = $processor->extractImages($document);

    expect($images)->toHaveCount(1)
        ->and($images[0])->toBeInstanceOf(Image::class);
});

test('extractImages handles mixed content with images and text', function () {
    $processor = new MarkdownImageProcessor();

    $environment = new Environment();
    $environment->addExtension(new CommonMarkCoreExtension());
    $parser = new MarkdownParser($environment);

    $markdown = 'Some text ![Image 1](https://example.com/1.jpg) more text ![Image 2](https://example.com/2.jpg)';
    $document = $parser->parse($markdown);

    $images = $processor->extractImages($document);

    expect($images)->toHaveCount(2)
        ->and($images[0])->toBeInstanceOf(Image::class)
        ->and($images[1])->toBeInstanceOf(Image::class)
        ->and($images[0]->getUrl())->toBe('https://example.com/1.jpg')
        ->and($images[1]->getUrl())->toBe('https://example.com/2.jpg');
});

test('extractImages handles nested nodes', function () {
    $processor = new MarkdownImageProcessor();

    $environment = new Environment();
    $environment->addExtension(new CommonMarkCoreExtension());
    $parser = new MarkdownParser($environment);

    $markdown = <<<'MD'
# Heading

Some paragraph with ![image](https://example.com/image.jpg).

> Quote with ![another image](https://example.com/image2.jpg)
MD;

    $document = $parser->parse($markdown);

    $images = $processor->extractImages($document);

    expect($images)->toHaveCount(2)
        ->and($images[0]->getUrl())->toBe('https://example.com/image.jpg')
        ->and($images[1]->getUrl())->toBe('https://example.com/image2.jpg');
});

test('containsOnlyImages returns true for paragraph with only images', function () {
    $processor = new MarkdownImageProcessor();

    $environment = new Environment();
    $environment->addExtension(new CommonMarkCoreExtension());
    $parser = new MarkdownParser($environment);

    $markdown = '![Image](https://example.com/image.jpg)';
    $document = $parser->parse($markdown);

    // Get the first paragraph
    $paragraph = $document->firstChild();

    expect($paragraph)->toBeInstanceOf(Paragraph::class)
        ->and($processor->containsOnlyImages($paragraph))->toBeTrue();
});

test('containsOnlyImages returns false for paragraph with text and images', function () {
    $processor = new MarkdownImageProcessor();

    $environment = new Environment();
    $environment->addExtension(new CommonMarkCoreExtension());
    $parser = new MarkdownParser($environment);

    $markdown = 'Some text ![Image](https://example.com/image.jpg) more text';
    $document = $parser->parse($markdown);

    // Get the first paragraph
    $paragraph = $document->firstChild();

    expect($paragraph)->toBeInstanceOf(Paragraph::class)
        ->and($processor->containsOnlyImages($paragraph))->toBeFalse();
});

test('containsOnlyImages returns false for paragraph with only text', function () {
    $processor = new MarkdownImageProcessor();

    $environment = new Environment();
    $environment->addExtension(new CommonMarkCoreExtension());
    $parser = new MarkdownParser($environment);

    $markdown = 'Just some text without images';
    $document = $parser->parse($markdown);

    // Get the first paragraph
    $paragraph = $document->firstChild();

    expect($paragraph)->toBeInstanceOf(Paragraph::class)
        ->and($processor->containsOnlyImages($paragraph))->toBeFalse();
});

test('containsOnlyImages handles multiple images with whitespace', function () {
    $processor = new MarkdownImageProcessor();

    $environment = new Environment();
    $environment->addExtension(new CommonMarkCoreExtension());
    $parser = new MarkdownParser($environment);

    $markdown = '![Image 1](https://example.com/1.jpg) ![Image 2](https://example.com/2.jpg)';
    $document = $parser->parse($markdown);

    // Get the first paragraph
    $paragraph = $document->firstChild();

    expect($paragraph)->toBeInstanceOf(Paragraph::class)
        ->and($processor->containsOnlyImages($paragraph))->toBeTrue();
});

test('containsOnlyImages returns false for empty paragraph', function () {
    $processor = new MarkdownImageProcessor();

    // Create an empty paragraph manually
    $paragraph = new Paragraph();

    expect($processor->containsOnlyImages($paragraph))->toBeFalse();
});
