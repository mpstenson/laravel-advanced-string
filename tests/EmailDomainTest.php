<?php

use mpstenson\AdvStr\Facades\AdvStr;

test('Can get email domain', function () {
    $domain = AdvStr::emailDomain('dXbKs@example.com');
    expect($domain)->toBe('example.com');
});

test('Can get email domain with subdomain', function () {
    $domain = AdvStr::emailDomain('X9LZ5@test.example.com');
    expect($domain)->toBe('test.example.com');
});

test('Can get email domain with trailing spaces and text', function () {
    $domain = AdvStr::emailDomain('dXbKs@example.com  some more text');
    expect($domain)->toBe('example.com');
});

test('Cat get email domain with not allowed characters afterwards', function () {
    $domain = AdvStr::emailDomain('"example user" <example@example.com>');
    expect($domain)->toBe('example.com');
});
