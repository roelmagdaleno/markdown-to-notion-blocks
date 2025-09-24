<?php

declare(strict_types=1);

use League\CommonMark\Exception\CommonMarkException;
use League\Config\Exception\ConfigurationExceptionInterface;
use RoelMR\MarkdownToNotionBlocks\MarkdownToNotionBlocks;

/**
 * Convert markdown to Notion blocks in JSON format.
 *
 * This function only loads in Pest tests.
 *
 * @param  string  $markdown  Markdown content.
 * @return string The Notion blocks from parsed markdown in JSON string.
 *
 * @throws CommonMarkException
 * @throws ConfigurationExceptionInterface
 */
function convert(string $markdown): string
{
    return MarkdownToNotionBlocks::json($markdown);
}

function expectedJson(array $expected): string
{
    return json_encode([[$expected]]);
}
