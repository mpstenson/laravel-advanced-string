<?php

use mpstenson\AdvStr\Facades\AdvStr;

test('Can generate a random phrase', function () {
    $phrase = AdvStr::randomPhrase(3);
    expect($phrase)->toBeString()
        ->and($phrase)->toContain('-')
        ->and(substr_count($phrase, '-'))->toBe(2);
});

test('Can generate a random phrase with custom separator', function () {
    $phrase = AdvStr::randomPhrase(4, '_');
    expect($phrase)->toBeString()
        ->and($phrase)->toContain('_')
        ->and(substr_count($phrase, '_'))->toBe(3);
});

test('Can generate a random phrase with specified word count', function () {
    $wordCounts = [1, 3, 5, 10];
    foreach ($wordCounts as $count) {
        $phrase = AdvStr::randomPhrase($count);
        $words = explode('-', $phrase);
        expect($words)->toHaveCount($count);
    }
});

test('Random phrases are not the same', function () {
    $phrase1 = AdvStr::randomPhrase(5);
    $phrase2 = AdvStr::randomPhrase(5);
    expect($phrase1)->not()->toBe($phrase2);
});

test('Can generate a phrase with no separator', function () {
    $phrase = AdvStr::randomPhrase(3, '');
    expect($phrase)->toBeString()
        ->and($phrase)->not()->toContain('-')
        ->and($phrase)->not()->toContain(' ');
});
