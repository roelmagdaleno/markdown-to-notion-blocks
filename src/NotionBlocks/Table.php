<?php

declare(strict_types=1);

namespace RoelMR\MarkdownToNotionBlocks\NotionBlocks;

use League\CommonMark\Extension\Table\Table as CommonMarkTable;
use League\CommonMark\Extension\Table\TableRow as CommonMarkTableRow;
use League\CommonMark\Extension\Table\TableSection;
use RoelMR\MarkdownToNotionBlocks\Objects\NotionBlock;

final class Table extends NotionBlock
{
    /**
     * Table constructor.
     *
     * @param  CommonMarkTable  $node  The table node.
     *
     * @see https://developers.notion.com/reference/block#table
     */
    public function __construct(public CommonMarkTable $node) {}

    /**
     * {@inheritDoc}
     */
    public function object(): array
    {
        $tableRows = [];
        $tableWidth = 0;
        $hasHeader = $this->hasHeader();

        // Process table sections
        foreach ($this->node->children() as $section) {
            if (!$section instanceof TableSection) {
                continue;
            }

            foreach ($section->children() as $row) {
                if ($row instanceof CommonMarkTableRow) {
                    $cells = $this->getRowCells($row);
                    $tableWidth = max($tableWidth, count($cells));
                    $tableRows[] = [
                        'type' => 'table_row',
                        'table_row' => ['cells' => $cells],
                    ];
                }
            }
        }

        // Ensure minimum requirements for Notion table
        if (empty($tableRows)) {
            $tableWidth = 1;
            $tableRows[] = [
                'type' => 'table_row',
                'table_row' => ['cells' => [[]]],
            ];
        }

        return [
            [
                'type' => 'table',
                'table' => [
                    'table_width' => $tableWidth,
                    'has_column_header' => $hasHeader,
                    'has_row_header' => false,
                    'children' => $tableRows,
                ],
            ],
        ];
    }

    /**
     * Check if the table has a header row by checking for separators.
     *
     * @return bool True if table has headers
     */
    private function hasHeader(): bool
    {
        // Check if there are at least 2 sections (header + body)
        $sections = [];
        foreach ($this->node->children() as $section) {
            if ($section instanceof TableSection) {
                $sections[] = $section;
            }
        }

        return count($sections) > 1;
    }

    /**
     * Extract cells from a table row.
     *
     * @param  CommonMarkTableRow  $row  The table row node.
     * @return array The cells as rich text arrays.
     */
    private function getRowCells(CommonMarkTableRow $row): array
    {
        $cells = [];

        foreach ($row->children() as $cell) {
            $richTextContent = $this->richText($cell);

            // If the cell is empty (no content), add empty array
            if (empty($richTextContent)) {
                $cells[] = [];

                continue;
            }

            // Check for single empty text content
            if (count($richTextContent) === 1 &&
                isset($richTextContent[0]['text']['content']) &&
                mb_trim($richTextContent[0]['text']['content']) === '') {
                $cells[] = [];

                continue;
            }

            $cells[] = $richTextContent;
        }

        return $cells;
    }
}
