<?php

use mpstenson\AdvStr\Facades\AdvStr;

test('Can calculate read time', function () {
    $time = AdvStr::readTime('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec euismod, nisl eget aliquam');
    expect($time)->toBe(4.0);
});

test('Can set custom wpm', function () {
    $time = AdvStr::readTime('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec euismod, nisl eget aliquam', 100);
    expect($time)->toBe(8.0);
});

test('can return 0 for empty string', function () {
    $time = AdvStr::readTime('');
    expect($time)->toBe(0.0);
});
