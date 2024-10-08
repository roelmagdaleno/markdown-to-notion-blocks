# Markdown to Notion Blocks

This package allows you to convert markdown to Notion blocks in JSON or Array format.

The generated [Notion blocks](https://developers.notion.com/reference/block), in JSON format, are intended to be sent to the [Notion API](https://developers.notion.com/docs/getting-started) to create a new page or update an existing one.

It's using [thephpleague/commonmark](https://github.com/thephpleague/commonmark) under the hood to parse the Markdown.

## Installation

You can install the package via composer:

```bash
composer require roelmagdaleno/markdown-to-notion-blocks
```

## Size Limits

### Maximum Blocks

The Notion API only accepts a maximum of 100 blocks per request. So, this package will always return an array, in chunks, of 100 blocks.

You'll have to send each chunk to the Notion API separately.

### Text Content

The Notion API only accepts a maximum of 2000 characters per text content. If the text content is more than 2000 characters, the package will split them into multiple rich text objects.

### Rich Text

The Notion API only accepts a maximum of 100 rich text objects per block. If the rich text objects are more than 100, the package will split them into multiple blocks.

## Usage

This package provides a `MarkdownToNotionBlocks` class that you can use to convert markdown to Notion blocks in JSON or Array format.

### Array

The `MarkdownToNotionBlocks::array` static method will return the Notion blocks in array format.

```php
use RoelMR\MarkdownToNotionBlocks\MarkdownToNotionBlocks;

$markdown = '# Hello, world!';
$notionBlocks = MarkdownToNotionBlocks::array($markdown);

print_r($notionBlocks);
```

The code above will output the following array:

```text
Array
(
    [0] => Array
        (
            [0] => Array
                (
                    [object] => block
                    [type] => heading_1
                    [heading_1] => Array
                        (
                            [rich_text] => Array
                                (
                                    [0] => Array
                                        (
                                            [type] => text
                                            [text] => Array
                                                (
                                                    [content] => Hello, world!
                                                    [link] => 
                                                )
                                            [annotations] => Array
                                                (
                                                    [bold] => 
                                                    [italic] => 
                                                    [strikethrough] => 
                                                    [underline] => 
                                                    [code] => 
                                                    [color] => default
                                                )
                                        )
                                )
                            [color] => default
                            [is_toggleable] => 
                        )
                )
        )
)
```

### JSON

The `MarkdownToNotionBlocks::json` static method will return the Notion blocks in JSON format.

> [!NOTE]
> Since the Notion blocks are returned in chunks of 100, the JSON output might not be valid for the Notion API. The JSON output is useful for debugging purposes or send it from the server to the client.

```php
use RoelMR\MarkdownToNotionBlocks\MarkdownToNotionBlocks;

$markdown = '# Hello, world!';
$notionBlocks = MarkdownToNotionBlocks::json($markdown);

echo $notionBlocks;
```

The code above will output the following JSON:

```json
[
  [
    {
      "object": "block",
      "type": "heading_1",
      "heading_1": {
        "rich_text": [
          {
            "type": "text",
            "text": {
              "content": "Hello, world!",
              "link": null
            },
            "annotations": {
              "bold": false,
              "italic": false,
              "strikethrough": false,
              "underline": false,
              "code": false,
              "color": "default"
            }
          }
        ],
        "color": "default",
        "is_toggleable": false
      }
    }
  ]
]
```

## Transform Output

If you want to transform the output before sending to the Notion API, you can use the `MarkdownToNotionBlocks::array` method
to get the Notion blocks in array format and then apply your transformations.

For example, by default each Notion block has a `color` property set to `default`. If you want to change the color of the heading to `red`, you can do the following:

```php
use RoelMR\MarkdownToNotionBlocks\MarkdownToNotionBlocks;

$markdown = '# Hello, world!';

$notionBlocks = MarkdownToNotionBlocks::array($markdown);

$notionBlocks[0]['heading_1']['rich_text'][0]['text']['content'] = 'My heading changed.';
$notionBlocks[0]['heading_1']['color'] = 'red';

echo json_encode($notionBlocks);
```

After applying the transformation, encode the array to JSON and send it to the [Notion API](https://developers.notion.com/docs/getting-started).

## Supported Notion Blocks

The following Notion blocks are supported by this package:

- [Bulleted List](https://developers.notion.com/reference/block#bulleted-list-item)
- [Callout](https://developers.notion.com/reference/block#callout)
- [Code](https://developers.notion.com/reference/block#code)
- [Headings](https://developers.notion.com/reference/block#headings)
- [Numbered List](https://developers.notion.com/reference/block#numbered-list-item)
- [Paragraph](https://developers.notion.com/reference/block#paragraph)
- [Quote](https://developers.notion.com/reference/block#quote)
- [To do](https://developers.notion.com/reference/block#to-do)

Each block support [rich text](https://developers.notion.com/reference/rich-text) properties like bold, italic, strikethrough, underline, and inline code.

## Example

The following example shows how to convert a Markdown string to Notion blocks in Array format.

```php
use RoelMR\MarkdownToNotionBlocks\MarkdownToNotionBlocks;

$markdown = file_get_contents($file_path);

$notion_blocks = MarkdownToNotionBlocks::array($markdown);

if (!$notion_blocks) {
    return false;
}

$notion_db_id = '101c7zs03d0680e6aa1cf27a0e61e8f4';

foreach ($notion_blocks as $notion_block) {
    append_blocks_to_notion_page($notion_db_id, $notion_block);
}
```

## Testing

```bash
composer test
```
