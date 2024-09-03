<?php

test('empty content returns an empty response', function () {
    $markdown = <<<MD
    ** **
    MD;

    $expected = [];

    expect(convert($markdown))->toBe(json_encode($expected));
});
