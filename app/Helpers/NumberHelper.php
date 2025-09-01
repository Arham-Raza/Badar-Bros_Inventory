<?php

namespace App\Helpers;

class NumberHelper
{
    /**
     * Convert a number to words (supports up to billions, 2 decimal places)
     */
    public static function toWords($number)
    {
        if (!is_numeric($number)) {
            return '';
        }
        $number = round($number, 2);
        $integer = (int) $number;
        $fraction = (int) round(($number - $integer) * 100);

        $words = self::convertNumber($integer);
        if ($fraction > 0) {
            $words .= ' and ' . self::convertNumber($fraction) . ' Paisa';
        }
        return $words;
    }

    protected static function convertNumber($number)
    {
        $hyphen      = '-';
        $conjunction = ' and ';
        $separator   = ', ';
        $negative    = 'negative ';
        $decimal     = ' point ';
        $dictionary  = [
            0                   => 'zero',
            1                   => 'one',
            2                   => 'two',
            3                   => 'three',
            4                   => 'four',
            5                   => 'five',
            6                   => 'six',
            7                   => 'seven',
            8                   => 'eight',
            9                   => 'nine',
            10                  => 'ten',
            11                  => 'eleven',
            12                  => 'twelve',
            13                  => 'thirteen',
            14                  => 'fourteen',
            15                  => 'fifteen',
            16                  => 'sixteen',
            17                  => 'seventeen',
            18                  => 'eighteen',
            19                  => 'nineteen',
            20                  => 'twenty',
            30                  => 'thirty',
            40                  => 'forty',
            50                  => 'fifty',
            60                  => 'sixty',
            70                  => 'seventy',
            80                  => 'eighty',
            90                  => 'ninety',
            100                 => 'hundred',
            1000                => 'thousand',
            100000              => 'lakh',
            10000000            => 'crore',
            1000000000          => 'billion'
        ];

        if (!is_numeric($number)) {
            return '';
        }

        if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
            // overflow
            return '';
        }

        if ($number < 0) {
            return $negative . self::convertNumber(abs($number));
        }

        $string = '';

        switch (true) {
            case $number < 21:
                $string = $dictionary[$number];
                break;
            case $number < 100:
                $tens   = ((int) ($number / 10)) * 10;
                $units  = $number % 10;
                $string = $dictionary[$tens];
                if ($units) {
                    $string .= $hyphen . $dictionary[$units];
                }
                break;
            case $number < 1000:
                $hundreds  = (int) ($number / 100);
                $remainder = $number % 100;
                $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
                if ($remainder) {
                    $string .= $conjunction . self::convertNumber($remainder);
                }
                break;
            case $number < 100000:
                $thousands   = (int) ($number / 1000);
                $remainder = $number % 1000;
                $string = self::convertNumber($thousands) . ' ' . $dictionary[1000];
                if ($remainder) {
                    $string .= $separator . self::convertNumber($remainder);
                }
                break;
            case $number < 10000000:
                $lakhs   = (int) ($number / 100000);
                $remainder = $number % 100000;
                $string = self::convertNumber($lakhs) . ' ' . $dictionary[100000];
                if ($remainder) {
                    $string .= $separator . self::convertNumber($remainder);
                }
                break;
            case $number < 1000000000:
                $crores   = (int) ($number / 10000000);
                $remainder = $number % 10000000;
                $string = self::convertNumber($crores) . ' ' . $dictionary[10000000];
                if ($remainder) {
                    $string .= $separator . self::convertNumber($remainder);
                }
                break;
            default:
                $billions   = (int) ($number / 1000000000);
                $remainder = $number % 1000000000;
                $string = self::convertNumber($billions) . ' ' . $dictionary[1000000000];
                if ($remainder) {
                    $string .= $separator . self::convertNumber($remainder);
                }
                break;
        }

        return $string;
    }
}
