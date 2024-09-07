# Markdown to Notion Blocks

This package allows you to **convert markdown to Notion Blocks** in JSON or Array format.

It's using [thephpleague/commonmark](https://github.com/thephpleague/commonmark) under the hood to parse the Markdown.

## Installation

You can install the package via composer:

```bash
composer require roelmagdaleno/markdown-to-notion-blocks
```

## Usage

This package provides a `MarkdownToNotionBlocks` class that you can use to convert markdown to Notion Blocks in JSON or Array format.

### JSON

The `MarkdownToNotionBlocks::json` static method will return the Notion blocks in JSON format.

```php
use RoelMagdaleno\MarkdownToNotionBlocks\MarkdownToNotionBlocks;

$markdown = '# Hello, world!';
$notionBlocks = MarkdownToNotionBlocks::json($markdown);

echo $notionBlocks;
```

The code above will output the following JSON:

```json
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
```

### Array

The `MarkdownToNotionBlocks::array` static method will return the Notion blocks in Array format.

```php
use RoelMagdaleno\MarkdownToNotionBlocks\MarkdownToNotionBlocks;

$markdown = '# Hello, world!';
$notionBlocks = MarkdownToNotionBlocks::array($markdown);

print_r($notionBlocks);
```

The code above will output the following array:

```php
Array
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
```
