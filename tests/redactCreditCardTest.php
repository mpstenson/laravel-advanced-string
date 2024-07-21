<?php

use mpstenson\AdvStr\Facades\AdvStr;

test('Redacts visa credit card numbers', function () {
    expect(AdvStr::redactCreditCard('my visa card is 4111-1111-1111-1111',exclude:['mastercard','amex','discover','diners','jcb']))->toBe('my visa card is ********');
});

test('Redacts mastercard credit card numbers', function () {
    expect(AdvStr::redactCreditCard('my mastercard card is 5555-5555-5555-4444',exclude:['visa','amex','discover','diners','jcb']))->toBe('my mastercard card is ********');
});

test('Redacts amex credit card numbers', function () {
    expect(AdvStr::redactCreditCard('my amex card is 378282246310005',exclude:['mastercard','visa','discover','diners','jcb']))->toBe('my amex card is ********');
});

test('Redacts discover credit card numbers', function () {
    expect(AdvStr::redactCreditCard('my discover card is 6011111111111117',exclude:['mastercard','visa','amex','diners','jcb']))->toBe('my discover card is ********');
});

test('Redacts diners club credit card numbers', function () {
    expect(AdvStr::redactCreditCard('my diners club card is 30569309025904',exclude:['mastercard','visa','amex','discover','jcb']))->toBe('my diners club card is ********');
});

test('Redacts jcb credit card numbers', function () {
    expect(AdvStr::redactCreditCard('my jcb card is 3530111333300000',exclude:['mastercard','visa','amex','discover','diners']))->toBe('my jcb card is ********');
});

test('Does not redact credit card numbers when excluded', function () {
    expect(AdvStr::redactCreditCard('my visa card is 4111-1111-1111-1111', '', ['visa']))->toBe('my visa card is 4111-1111-1111-1111');
});

test('Redacts credit card numbers with custom redacted string', function () {
    expect(AdvStr::redactCreditCard('my visa card is 4111-1111-1111-1111', 'redacted'))->toBe('my visa card is redacted');
});