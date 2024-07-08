<?php

use mpstenson\AdvStr\Facades\AdvStr;

test('Can split name first and last name with space', function () {
    $name = AdvStr::splitName('John Smith');
    expect($name)->toHaveCount(2)
        ->and($name['first'])->toBe('John')
        ->and($name['last'])->toBe('Smith');
});

test('Can split name first and last name with comma', function () {
    $name = AdvStr::splitName('Smith, John');
    expect($name)->toHaveCount(2)
        ->and($name['first'])->toBe('John')
        ->and($name['last'])->toBe('Smith');
});

test('Can split name with prefix with period', function () {
    $name = AdvStr::splitName('Mr. John Smith');
    expect($name)->toHaveCount(2)
        ->and($name['first'])->toBe('John')
        ->and($name['last'])->toBe('Smith');
});

test('Can split name with prefix with space', function () {
    $name = AdvStr::splitName('Mr John Smith');
    expect($name)->toHaveCount(2)
        ->and($name['first'])->toBe('John')
        ->and($name['last'])->toBe('Smith');
});

test('Can find middle name', function () {
    $name = AdvStr::splitName('John Doe Smith Jr.');
    expect($name)->toHaveCount(3)
        ->and($name['first'])->toBe('John')
        ->and($name['middle'])->toBe('Doe')
        ->and($name['last'])->toBe('Smith');
});

test('Can remove suffix', function () {
    $name = AdvStr::splitName('John Smith III');
    expect($name)->toHaveCount(3)
        ->and($name['first'])->toBe('John')
        ->and($name['last'])->toBe('Smith');
});
