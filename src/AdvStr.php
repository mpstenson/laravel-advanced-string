<?php

namespace mpstenson\AdvStr;

use Illuminate\Support\Collection;

class AdvStr
{
    /**
     * Generate a random, secure password.
     *
     * @param  int  $length
     * @param  bool  $letters
     * @param  bool  $numbers
     * @param  bool  $symbols
     * @param  bool  $spaces
     * @param  bool  $upperLetters
     * @param  bool  $lowerLetters
     * @param  array  $exclude
     * @return string
     */
    public static function advPassword($length = 32, $letters = true, $numbers = true, $symbols = true, $spaces = false, $upperLetters = false, $lowerLetters = false, $exclude = [])
    {
        $password = new Collection();

        // $letters enables both upper case and lower case letters to create a mixed case password
        if ($letters === true) {
            $upperLetters = true;
            $lowerLetters = true;
        }

        $options = (new Collection([
            'upperLetters' => $upperLetters === true ? [
                'A', 'B', 'C', 'D', 'E', 'F', 'G',
                'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R',
                'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
            ] : null,
            'lowerLetters' => $lowerLetters === true ? [
                'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k',
                'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v',
                'w', 'x', 'y', 'z',
            ] : null,
            'numbers' => $numbers === true ? [
                '0', '1', '2', '3', '4', '5', '6', '7', '8', '9',
            ] : null,
            'symbols' => $symbols === true ? [
                '~', '!', '#', '$', '%', '^', '&', '*', '(', ')', '-',
                '_', '.', ',', '<', '>', '?', '/', '\\', '{', '}', '[',
                ']', '|', ':', ';',
            ] : null,
            'spaces' => $spaces === true ? [' '] : null,
        ]))->filter();

        // Remove excluded characters
        $options = $options->map(function ($chars) use ($exclude) {
            return array_values(array_diff($chars, $exclude));
        })->filter(function ($chars) {
            return ! empty($chars);
        });

        $options->each(fn ($c) => $password->push($c[random_int(0, count($c) - 1)]));
        // add the remaining characters to the password

        // Calculate remaining length
        $remainingLength = $length - $password->count();

        // Generate remaining characters
        $allChars = $options->flatten()->toArray();
        for ($i = 0; $i < $remainingLength; $i++) {
            $password->push($allChars[random_int(0, count($allChars) - 1)]);
        }

        return $password->shuffle()->implode('');
    }

    /**
     * Calculate the read time of a string.
     *
     * @param  string  $string
     * @param  int  $wpm
     * @return float
     */
    public static function readTime($string, $wpm = 200)
    {
        /**
         * Silent-reading adults average 238 words per minute.
         * Adults who read aloud average 183 words per minute.
         * We average to 200 words per minute.
         */

        // Calculate the number of words in the string
        $word_count = str_word_count($string);

        // Calculate words per second
        $wps = $wpm / 60;

        // Calculate the number of seconds it takes to read the string
        $seconds = $word_count / $wps;

        // Return the reading time in seconds
        return round($seconds);
    }

    /**
     * Wrap a string at a given number of characters regardless of words.
     *
     * @param  string  $string  The string to wrap.
     * @param  int  $length  The number of characters to wrap at.
     * @return string The wrapped string.
     */
    public static function charWrap($string, $length = 80)
    {
        // split the string into an array of string x characters long
        $string = str_split($string, $length);
        $string = implode("\n", $string);

        return $string;
    }

    /**
     * First name last name splitter, returns an array of first and last name
     * and removes any prefixes
     *
     * @param  string  $name
     * @return array
     */
    public static function splitName($name)
    {
        $prefixes = [  // Titles with periods
            'Mr.',
            'Mrs.',
            'Ms.',
            'Mx.',  // Mx. is a gender-neutral prefix
            'Dr.',
            'Prof.',
            'Rev.',  // Reverend
            'Sr.',   // Sister (religious)
            'Fr.',   // Father (religious)
            'Capt.',  // Captain
            'Lt.',    // Lieutenant
            'Col.',   // Colonel
            'Gen.',   // General
            'Maj.',   // Major
            'Sgt.',   // Sergeant
            'Lord',
            'Lady',
            'Sir',
            'Saint',

            // Titles without periods
            'Doctor',
            'Professor',
            'Reverend',
            'Rev',
            'Sister',
            'Father',
            'Captain',
            'Lieutenant',
            'Colonel',
            'General',
            'Major',
            'Sergeant',
            'Madame',  // French for Ms.
            'Mademoiselle',  // French for Miss (unmarried woman)
            'Monsignor',  // Catholic title
            'Rabbi',
            'Imam',
            'Sheikh',
            'Master',  // Used for some professions (e.g., Master Sergeant)
            'Miss',   // Traditionally used for unmarried women (less common now)
            'Mister',  // Less common variation of Mr.
            'Mx',      // Non-period version of Mx.
            'Mr',     // Non-period version of Mr.
            'Mrs',    // Non-period version of Mrs.
            'Ms',     // Non-period version of Ms.
            'Coach',
            'Dr.',   // Can be used informally for medical doctors
            'Prof.',  // Can be used informally for professors
            'Ms.',   // Can be used informally for women
        ];

        $suffixes = [
            'PhD',
            'MD',
            'DDS',
            'DVM',
            'Ph.D.',
            'Jr.',
            'Sr.',
            'I',
            'II',
            'III',
            'IV',
            'V',
            'VI',
            'VII',
            'VIII',
            'IX',
            'X',
        ];

        // Add lower case version of the prefixes while keeping the original versions
        $prefixes = array_merge($prefixes, array_map('strtolower', $prefixes), array_map('strtoupper', $prefixes));
        $suffixes = array_merge($suffixes, array_map('strtolower', $suffixes), array_map('strtoupper', $suffixes));

        // Remove any matching prefixes
        foreach ($prefixes as $prefix) {
            if (stripos($name, $prefix) === 0) {  // Check if the prefix is at the beginning
                // Remove the prefix
                $name = trim(substr($name, strlen($prefix)));
            }
        }

        //if name has commas assume it is in the order last, first
        if (strpos($name, ',') !== false) {
            $name = explode(',', $name);

            return [
                'first' => trim($name[1]),
                'last' => trim($name[0]),
            ];
        } else {
            $name = explode(' ', $name);
            if (count($name) > 2) {
                // remove any suffixes
                $name = array_diff($name, $suffixes);

                return [
                    // get the first
                    'first' => $name[0],
                    //middle names will be any array items between the first and last names
                    'middle' => implode(' ', array_slice($name, 1, count($name) - 2)),
                    'last' => $name[count($name) - 1],
                ];
            }

            return [
                'first' => $name[0],
                'last' => $name[1],
            ];
        }
    }

    /**
     * Redacts ssn numbers and replaces them with a given string
     *
     * @param  string  $string
     * @param  string  $redacted  // default '********'
     * @param  bool  $dashes  // redact ssn with dashes
     * @param  bool  $noDashes  // redact ssn without dashes
     * @return string
     */
    public static function redactSsn($string, $redacted = '********', $dashes = true, $noDashes = true)
    {
        $ssnRegex = '/\b(?<!\-)(?!666|000|9\d{2})\d{3}-(?!00)\d{2}-(?!0{4})\d{4}(?!\-)\b/';
        $ssnNoDashRegex = '/\b\d{9}(?!\d|\-\d)\b/';
        if ($dashes) {
            $string = preg_replace($ssnRegex, $redacted, $string);
        }
        if ($noDashes) {
            $string = preg_replace($ssnNoDashRegex, $redacted, $string);
        }

        return $string;
    }

    /**
     * Extracts the domain from an email address.
     *
     * @param  string  $string  The email address to extract the domain from.
     * @return string The domain extracted from the email address.
     */
    public static function emailDomain($string)
    {
        // Extract the domain using regex
        if (preg_match('/@([a-zA-Z0-9.-]+)/', $string, $matches)) {
            return $matches[1];
        }

        return '';
    }

    /**
     * Redacts credit card numbers and replaces them with a given string
     *
     * @param  $redacted  // default '********'
     * @return string
     */
    public static function redactCreditCard($string, $redacted = '********', $exclude = [])
    {
        // Check visa pattern
        $visa = '/\b4[0-9]{3}[-\s]?[0-9]{4}[-\s]?[0-9]{4}[-\s]?[0-9]{4}\b/';
        // Check mastercard pattern
        $mastercard = '/\b(?:5[1-5][0-9]{2}|222[1-9]|22[3-9][0-9]|2[3-6][0-9]{2}|27[01][0-9]|2720)(?:[-\s]?[0-9]{4}){3}\b/';
        // Check amex pattern
        $amex = '/\b3[47][0-9]{13}\b/';
        // Check discover pattern
        $discover = '/\b6(?:011[-\s]?[0-9]{4}[-\s]?[0-9]{4}[-\s]?[0-9]{4}|5[0-9]{2}[-\s]?[0-9]{4}[-\s]?[0-9]{4}[-\s]?[0-9]{4})\b/';
        // Check diners club pattern
        $diners = '/\b3(?:0[0-5]|[68][0-9])(?:[-\s]?[0-9]{4}){2}[-\s]?[0-9]{3}\b/';
        // Check jcb pattern
        $jcb = '/\b(?:2131|1800|35\d{2})(?:[-\s]?[0-9]{4}){3}\b/';

        // for each pattern not excluded run a preg_replace
        if (! in_array('visa', $exclude)) {
            $string = preg_replace($visa, $redacted, $string);
        }
        if (! in_array('mastercard', $exclude)) {
            $string = preg_replace($mastercard, $redacted, $string);
        }
        if (! in_array('amex', $exclude)) {
            $string = preg_replace($amex, $redacted, $string);
        }
        if (! in_array('discover', $exclude)) {
            $string = preg_replace($discover, $redacted, $string);
        }
        if (! in_array('diners', $exclude)) {
            $string = preg_replace($diners, $redacted, $string);
        }
        if (! in_array('jcb', $exclude)) {
            $string = preg_replace($jcb, $redacted, $string);
        }

        return $string;
    }
}
