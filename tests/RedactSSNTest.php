<?php

use mpstenson\AdvStr\Facades\AdvStr;

test('Redact dashed ssn', function () {
    expect(AdvStr::redactSsn('my ssn is 123-45-6789 thanks!'))->toBe('my ssn is ******** thanks!');
});

test('Redact dashed ssn with period at end', function () {
    expect(AdvStr::redactSsn('my ssn is 123-45-6789. thanks!'))->toBe('my ssn is ********. thanks!');
});

test('Does not redact other dashed numbers', function () {
    expect(AdvStr::redactSsn('My phone number is 123-123-1234. thanks!'))->toBe('My phone number is 123-123-1234. thanks!');
});

test('Redact no dashes ssn', function () {
    expect(AdvStr::redactSsn('my ssn is 123456789 thanks!'))->toBe('my ssn is ******** thanks!');
});

test('Redact no dashes ssn with period at end', function () {
    expect(AdvStr::redactSsn('my ssn is 123456789. thanks!'))->toBe('my ssn is ********. thanks!');
});

test('Does not redact other numbers', function () {
    expect(AdvStr::redactSsn('My phone number is 1231231234. thanks!'))->toBe('My phone number is 1231231234. thanks!');
});

test('Redact no dashes ssn can be disabled', function () {
    expect(AdvStr::redactSsn('my ssn is 123456789 thanks!', noDashes: false))->toBe('my ssn is 123456789 thanks!');
});

test('Redact dashes ssn can be disabled', function () {
    expect(AdvStr::redactSsn('my ssn is 123-45-6789 thanks!', dashes: false))->toBe('my ssn is 123-45-6789 thanks!');
});

test('can set redacted replacement string', function () {
    expect(AdvStr::redactSsn('my ssn is 123-45-6789 thanks!', '****'))->toBe('my ssn is **** thanks!');
});

test('only redact numbers', function () {
    expect(AdvStr::redactSsn('my serial number is asdf-11-1232. thanks!'))->toBe('my serial number is asdf-11-1232. thanks!');
});
