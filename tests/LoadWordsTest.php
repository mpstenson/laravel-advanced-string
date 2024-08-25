<?php

use mpstenson\AdvStr\AdvStr;
use ReflectionClass;

beforeEach(function () {
    $reflection = new ReflectionClass(AdvStr::class);
    $property = $reflection->getProperty('words');
    $property->setAccessible(true);
    $property->setValue(null, null);
});

test('words are initially null', function () {
    $reflection = new ReflectionClass(AdvStr::class);
    $property = $reflection->getProperty('words');
    $property->setAccessible(true);

    expect($property->getValue())->toBeNull();
});

test('words are loaded after calling loadWords', function () {
    $reflection = new ReflectionClass(AdvStr::class);
    $method = $reflection->getMethod('loadWords');
    $method->setAccessible(true);
    $method->invoke(null);

    $property = $reflection->getProperty('words');
    $property->setAccessible(true);

    expect($property->getValue())->toBeArray()->not->toBeEmpty();
});

test('words are loaded from words.json file', function () {
    $reflection = new ReflectionClass(AdvStr::class);
    $method = $reflection->getMethod('loadWords');
    $method->setAccessible(true);
    $method->invoke(null);

    $property = $reflection->getProperty('words');
    $property->setAccessible(true);

    $wordsFromJson = json_decode(file_get_contents(__DIR__.'/../src/words.json'), true);

    expect($property->getValue())->toBe($wordsFromJson);
});

test('words are only loaded once', function () {
    $reflection = new ReflectionClass(AdvStr::class);
    $method = $reflection->getMethod('loadWords');
    $method->setAccessible(true);

    // Call loadWords twice
    $method->invoke(null);
    $firstLoadTime = microtime(true);
    $method->invoke(null);
    $secondLoadTime = microtime(true);

    // The second load should be significantly faster if words are cached
    expect($secondLoadTime - $firstLoadTime)->toBeLessThan(0.001);
});
