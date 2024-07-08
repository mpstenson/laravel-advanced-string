# Laravel Advanced String Package
*Tested, community maintained, supercharged Laravel string functions.*

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mpstenson/laravel-advanced-string.svg?style=flat-square)](https://packagist.org/packages/mpstenson/laravel-advanced-string)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/mpstenson/laravel-advanced-string/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/mpstenson/laravel-advanced-string/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/mpstenson/laravel-advanced-string/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/mpstenson/laravel-advanced-string/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/mpstenson/laravel-advanced-string.svg?style=flat-square)](https://packagist.org/packages/mpstenson/laravel-advanced-string)

Laravel Advanced String is a Laravel package that adds advanced string manipulation methods to the built in `Str` class that Laravel provides. You get extended functionality on strings such as advanced password generation, data redaction, and more.

The Laravel Advanced String package by default adds macros to the `Str` class so your can access the extended functionality in the same class that your other string methods are found in. You can also disable this functionality the in the package config
and use the `AdvStr` class directly.

### Example
```php
Str::redactSsn('My social security number is 222-22-2222'); // My social security number is xxxxxx
```
OR...
```php
AdvStr::redactSsn('My social security number is 222-22-2222'); // My social security number is xxxxxx
```
## Installation

You can install the package via composer:

```bash
composer require mpstenson/laravel-advanced-string
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-advanced-string-config"
```

This is the contents of the published config file:

```php
return [

    /*
    // Macro the AdvStr class to the Illuminate\Support\Str class. You can disable
    // this here if you don't want the AdvStr methods available on the Str class
    */

    'use_str' => true,

];
```

## Usage
The Laravel Advanced String package by default adds macros to the `Str` class so your can access the extended functionality immediately
```php
Str::redactSsn('123-45-6789')
```

## Available Methods

### advPassword

Generates a random, secure password.

```php
public static function advPassword(
    $length = 32,
    $letters = true,
    $numbers = true,
    $symbols = true,
    $spaces = false,
    $upperLetters = false,
    $lowerLetters = false,
    $exclude = []
)
```

#### Parameters:
- `$length` (int): Length of the password (default: 32)
- `$letters` (bool): Include mixed case letters (default: true)
- `$numbers` (bool): Include numbers (default: true)
- `$symbols` (bool): Include symbols (default: true)
- `$spaces` (bool): Include spaces (default: false)
- `$upperLetters` (bool): Include uppercase letters (default: false)
- `$lowerLetters` (bool): Include lowercase letters (default: false)
- `$exclude` (array): Characters to exclude from the password

#### Returns:
- string: Generated password

### readTime

Calculates the read time of a string.

```php
public static function readTime(
    $string, 
    $wpm = 200
)
```

#### Parameters:
- `$string` (string): The text to calculate read time for
- `$wpm` (int): Words per minute (default: 200)

#### Returns:
- int: Estimated read time in seconds

### charWrap

Wraps a string at a given number of characters regardless of words.

```php
public static function charWrap(
    $string, 
    $length = 80
)
```

#### Parameters:
- `$string` (string): The string to wrap
- `$length` (int): The number of characters to wrap at (default: 80)

#### Returns:
- string: The wrapped string

### splitName

Splits a full name into first name, middle name (if present), and last name, removing any prefixes and suffixes. This method can handle both "Firstname Lastname" and "Lastname, Firstname" formats.

```php
public static function splitName(
    $name
)
```

#### Parameters:
- `$name` (string): The full name to split

#### Returns:
- array: An associative array containing 'first', 'middle' (if present), and 'last' name

### redactSsn

Redacts Social Security Numbers (SSN) in a string.

```php
public static function redactSsn(
    $string, 
    $redacted = '********', 
    $dashes = true, 
    $noDashes = true
)
```

#### Parameters:
- `$string` (string): The string containing SSNs to redact
- `$redacted` (string): The string to replace SSNs with (default: '********')
- `$dashes` (bool): Redact SSNs with dashes (default: true)
- `$noDashes` (bool): Redact SSNs without dashes (default: true)

#### Returns:
- string: The string with SSNs redacted

### redactCreditCard

Redacts credit card numbers in a string.

```php
public static function redactCreditCard(
    $string, 
    $redacted = '********', 
    $exclude = []
)
```

#### Parameters:
- `$string` (string): The string containing credit card numbers to redact
- `$redacted` (string): The string to replace credit card numbers with (default: '********')
- `$exclude` (array): An array of credit card types to exclude from redaction

#### Returns:
- string: The string with credit card numbers redacted

Note: This method is currently not implemented (TODO).
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Matt Stenson](https://github.com/mpstenson)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
