<?php

use mpstenson\AdvStr\Facades\AdvStr;

test('Can generate a random word', function () {
    $word = AdvStr::randomWord();
    expect($word)->toBeString()->not->toBeEmpty();
});

test('Random words are not always the same', function () {
    $word1 = AdvStr::randomWord();
    $word2 = AdvStr::randomWord();
    expect($word1)->not->toBe($word2);
});

test('Generated word is in the word list', function () {
    $word = AdvStr::randomWord();
    $wordList = json_decode(file_get_contents(__DIR__ . '/../src/words.json'), true);
    expect($wordList)->toContain($word);
});