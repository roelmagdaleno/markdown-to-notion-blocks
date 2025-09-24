<?php

declare(strict_types=1);

it('converts basic table to notion blocks', function () {
    $markdown = '| Name | Age | Occupation |
|------|-----|------------|
| Alice | 28 | Engineer |
| Bob | 34 | Designer |';

    $result = convert($markdown);
    $blocks = json_decode($result, true);

    expect($blocks)->toHaveCount(1)
        ->and($blocks[0])->toHaveCount(1);

    $table = $blocks[0][0];
    expect($table['type'])->toBe('table')
        ->and($table['table']['table_width'])->toBe(3)
        ->and($table['table']['has_column_header'])->toBe(true)
        ->and($table['table']['has_row_header'])->toBe(false)
        ->and($table['table']['children'])->toHaveCount(3);
    // 1 header + 2 data rows
});

it('converts table with header to notion blocks with correct structure', function () {
    $markdown = '| Name | Age | Occupation |
|------|-----|------------|
| Alice | 28 | Software Engineer |
| Bob | 34 | Designer |
| Charlie | 25 | Product Manager |';

    $result = convert($markdown);
    $blocks = json_decode($result, true);

    $table = $blocks[0][0];
    $children = $table['table']['children'];

    // Check header row
    expect($children[0]['type'])->toBe('table_row')
        ->and($children[0]['table_row']['cells'])->toHaveCount(3)
        ->and($children[0]['table_row']['cells'][0][0]['text']['content'])->toBe('Name')
        ->and($children[0]['table_row']['cells'][1][0]['text']['content'])->toBe('Age')
        ->and($children[0]['table_row']['cells'][2][0]['text']['content'])->toBe('Occupation')
        ->and($children[1]['table_row']['cells'][0][0]['text']['content'])->toBe('Alice')
        ->and($children[1]['table_row']['cells'][1][0]['text']['content'])->toBe('28')
        ->and($children[1]['table_row']['cells'][2][0]['text']['content'])->toBe('Software Engineer')
        ->and($children[2]['table_row']['cells'][0][0]['text']['content'])->toBe('Bob')
        ->and($children[2]['table_row']['cells'][1][0]['text']['content'])->toBe('34')
        ->and($children[2]['table_row']['cells'][2][0]['text']['content'])->toBe('Designer')
        ->and($children[3]['table_row']['cells'][0][0]['text']['content'])->toBe('Charlie')
        ->and($children[3]['table_row']['cells'][1][0]['text']['content'])->toBe('25')
        ->and($children[3]['table_row']['cells'][2][0]['text']['content'])->toBe('Product Manager');
});

it('converts table with empty headers to notion blocks', function () {
    $markdown = '| | | |
|---|---|---|
| Alice | 28 | Engineer |
| Bob | 34 | Designer |';

    $result = convert($markdown);
    $blocks = json_decode($result, true);

    $table = $blocks[0][0];
    expect($table['table']['has_column_header'])->toBe(true)
        ->and($table['table']['children'])->toHaveCount(3); // CommonMark always has headers
    // 1 empty header + 2 data rows
});

it('handles empty table cells', function () {
    $markdown = '| Name | Age | Occupation |
|------|-----|------------|
| Alice |  | Engineer |
|  | 34 |  |';

    $result = convert($markdown);
    $blocks = json_decode($result, true);

    $table = $blocks[0][0];
    $children = $table['table']['children'];

    expect($children[1]['table_row']['cells'][1])->toBeArray()
        ->and($children[1]['table_row']['cells'][1])->toBeEmpty()
        ->and($children[2]['table_row']['cells'][0])->toBeArray()
        ->and($children[2]['table_row']['cells'][0])->toBeEmpty()
        ->and($children[2]['table_row']['cells'][2])->toBeArray()
        ->and($children[2]['table_row']['cells'][2])->toBeEmpty();
});

it('handles table with different column widths', function () {
    $markdown = '| A | B | C | D |
|---|---|---|---|
| 1 | 2 |
| X | Y | Z |';

    $result = convert($markdown);
    $blocks = json_decode($result, true);

    $table = $blocks[0][0];
    expect($table['table']['table_width'])->toBe(4);
});
