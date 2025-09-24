<?php

declare(strict_types=1);

use RoelMR\MarkdownToNotionBlocks\MarkdownToNotionBlocks;

test('empty content returns an empty response', function () {
    $markdown = <<<'MD'
    ** **
    MD;

    $expected = [];

    expect(convert($markdown))->toBe(json_encode($expected));
});

test('get content as array', function () {
    $markdown = <<<'MD'
    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
    MD;

    expect(MarkdownToNotionBlocks::array($markdown))->toBeArray();
});
