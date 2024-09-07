<?php

use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\GithubFlavoredMarkdownExtension;
use RoelMR\MarkdownToNotionBlocks\MarkdownToNotionBlocksConverter;

test('empty content returns an empty response', function () {
    $markdown = <<<MD
    ** **
    MD;

    $expected = [];

    expect(convert($markdown))->toBe(json_encode($expected));
});

test('get content as array', function () {
    $environment = new Environment();
    $environment->addExtension(new CommonMarkCoreExtension());
    $environment->addExtension(new GithubFlavoredMarkdownExtension());

    $converter = new MarkdownToNotionBlocksConverter($environment);

    $markdown = <<<MD
    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
    MD;

    $content = $converter->convert($markdown);

    expect($content->toArray())->toBeArray();
});
