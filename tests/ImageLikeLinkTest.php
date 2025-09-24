<?php

declare(strict_types=1);

use League\CommonMark\Extension\CommonMark\Node\Inline\Link;
use RoelMR\MarkdownToNotionBlocks\Objects\ImageLikeLink;

test('ImageLikeLink returns correct URL from wrapped link', function () {
    $link = new Link('https://example.com/image.jpg', 'Link Title');
    $imageLikeLink = new ImageLikeLink($link, 'Alt Text');

    expect($imageLikeLink->getUrl())->toBe('https://example.com/image.jpg');
});

test('ImageLikeLink returns alt text as title when provided', function () {
    $link = new Link('https://example.com/image.jpg', 'Link Title');
    $imageLikeLink = new ImageLikeLink($link, 'Alt Text');

    expect($imageLikeLink->getTitle())->toBe('Alt Text');
});

test('ImageLikeLink falls back to link title when alt text is empty', function () {
    $link = new Link('https://example.com/image.jpg');
    $link->setTitle('Link Title');
    $imageLikeLink = new ImageLikeLink($link, '');

    expect($imageLikeLink->getTitle())->toBe('Link Title');
});

test('ImageLikeLink falls back to link title when alt text is whitespace', function () {
    $link = new Link('https://example.com/image.jpg');
    $link->setTitle('Link Title');
    $imageLikeLink = new ImageLikeLink($link, '   ');

    expect($imageLikeLink->getTitle())->toBe('   ');
});

test('ImageLikeLink handles link without title', function () {
    $link = new Link('https://example.com/image.jpg');
    $imageLikeLink = new ImageLikeLink($link, 'Alt Text');

    expect($imageLikeLink->getUrl())->toBe('https://example.com/image.jpg')
        ->and($imageLikeLink->getTitle())->toBe('Alt Text');
});

test('ImageLikeLink handles empty alt text and no link title', function () {
    $link = new Link('https://example.com/image.jpg');
    $imageLikeLink = new ImageLikeLink($link, '');

    expect($imageLikeLink->getUrl())->toBe('https://example.com/image.jpg')
        ->and($imageLikeLink->getTitle())->toBeNull();
});

test('ImageLikeLink preserves original link URL formatting', function () {
    $url = 'https://example.com/path/to/image.jpg?param=value&other=test';
    $link = new Link($url, 'Title');
    $imageLikeLink = new ImageLikeLink($link, 'Alt');

    expect($imageLikeLink->getUrl())->toBe($url);
});

test('ImageLikeLink handles relative URLs', function () {
    $link = new Link('./images/local-image.jpg', 'Local Image');
    $imageLikeLink = new ImageLikeLink($link, 'Local Alt Text');

    expect($imageLikeLink->getUrl())->toBe('./images/local-image.jpg')
        ->and($imageLikeLink->getTitle())->toBe('Local Alt Text');
});

test('ImageLikeLink handles special characters in alt text', function () {
    $link = new Link('https://example.com/image.jpg');
    $altText = 'Image with "quotes" & special chars <test>';
    $imageLikeLink = new ImageLikeLink($link, $altText);

    expect($imageLikeLink->getTitle())->toBe($altText);
});

test('ImageLikeLink handles unicode characters in alt text', function () {
    $link = new Link('https://example.com/image.jpg');
    $altText = 'Image with unicode: 🖼️ 中文 العربية';
    $imageLikeLink = new ImageLikeLink($link, $altText);

    expect($imageLikeLink->getTitle())->toBe($altText);
});
