<?php

use mpstenson\AdvStr\Facades\AdvStr;

test('Can create password', function () {
    expect(AdvStr::advPassword())->toBeString()->toHaveLength(32);
});

test('Can create mixed case password', function () {
    $password = AdvStr::advPassword(2, letters: true, numbers: false, symbols: false, spaces: false, upperLetters: false, lowerLetters: false);
    expect($password)->toHaveLength(2)
        ->and($password)->toMatch('/^[a-zA-Z]{2}$/')
        ->and($password)->toMatch('/^(?=.*[a-z])(?=.*[A-Z]).{2}$/');
});

test('Can exclude characters', function () {
    $password = AdvStr::advPassword(1, letters: false, numbers: true, symbols: false, spaces: false, upperLetters: false, lowerLetters: false, exclude: [1, 2, 3, 4, 5, 6, 7, 8, 9]);
    expect($password)->toHaveLength(1)
        ->and($password)->toMatch('/0/');
});

test('Can create password with numbers', function () {
    $password = AdvStr::advPassword(1, letters: false, numbers: true, symbols: false, spaces: false, upperLetters: false, lowerLetters: false);
    expect($password)->toHaveLength(1)
        ->and($password)->toMatch('/[0-9]/');
});

test('Can create password with symbols', function () {
    $password = AdvStr::advPassword(1, letters: false, numbers: false, symbols: true, spaces: false, upperLetters: false, lowerLetters: false);
    expect($password)->toHaveLength(1)
        ->and($password)->toMatch('/[~!#$%^&*()-_.<>?\/\\\{\}\[\]|:;]/');
});

test('Can create password with spaces', function () {
    $password = AdvStr::advPassword(1, letters: false, numbers: false, symbols: false, spaces: true, upperLetters: false, lowerLetters: false);
    expect($password)->toHaveLength(1)
        ->and($password)->toMatch('/ /');
});

test('Can create password with upper case letters', function () {
    $password = AdvStr::advPassword(1, letters: false, numbers: false, symbols: false, spaces: false, upperLetters: true, lowerLetters: false);
    expect($password)->toHaveLength(1)
        ->and($password)->toMatch('/[A-Z]/');
});

test('Can create password with lower case letters', function () {
    $password = AdvStr::advPassword(1, letters: false, numbers: false, symbols: false, spaces: false, upperLetters: false, lowerLetters: true);
    expect($password)->toHaveLength(1)
        ->and($password)->toMatch('/[a-z]/');
});

test('Can create password that requires multiple items', function () {
    $password = AdvStr::advPassword(5, letters: true, numbers: true, symbols: true, spaces: true, upperLetters: false, lowerLetters: false);
    expect($password)->toHaveLength(5)
        ->and($password)->toMatch('/[a-z]/')
        ->and($password)->toMatch('/[A-Z]/')
        ->and($password)->toMatch('/[0-9]/')
        ->and($password)->toMatch('/[~!#$%^&*()-_.<>?\/\\\{\}\[\]|:;]/')
        ->and($password)->toMatch('/ /');
});

test('Passwords are not the same', function () {
    $password = AdvStr::advPassword();
    $password2 = AdvStr::advPassword();
    expect($password)->not()->ToEqual($password2);
});
