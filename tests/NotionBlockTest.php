<?php

use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\GithubFlavoredMarkdownExtension;
use RoelMR\MarkdownToNotionBlocks\Converter\MarkdownToNotionBlocksConverter;
use RoelMR\MarkdownToNotionBlocks\MarkdownToNotionBlocks;

test('empty content returns an empty response', function () {
    $markdown = <<<MD
    ** **
    MD;

    $expected = [];

    expect(convert($markdown))->toBe(json_encode($expected));
});

test('get content as array', function () {
    $markdown = <<<MD
    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
    MD;

    expect(MarkdownToNotionBlocks::array($markdown))->toBeArray();
});
