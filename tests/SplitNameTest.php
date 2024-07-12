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

test('Dr. Matthew Paul Stenson Jr. is parsed correctly', function () {
    $name = AdvStr::splitName('dr. matthew paul stenson jr.');
    expect($name)->toHaveCount(3)
        ->and($name['first'])->toBe('matthew')
        ->and($name['middle'])->toBe('paul')
        ->and($name['last'])->toBe('stenson');
});

test('Two prefixes are parsed correctly', function () {
    $name = AdvStr::splitName('Rev Dr. matthew paul stenson jr.');
    expect($name)->toHaveCount(3)
        ->and($name['first'])->toBe('matthew')
        ->and($name['middle'])->toBe('paul')
        ->and($name['last'])->toBe('stenson');
});

test('Catch all caps versions', function () {
    $name = AdvStr::splitName('REV DR. MATTHEW PAUL STENSON JR.');
    expect($name)->toHaveCount(3)
        ->and($name['first'])->toBe('MATTHEW')
        ->and($name['middle'])->toBe('PAUL')
        ->and($name['last'])->toBe('STENSON');
});
