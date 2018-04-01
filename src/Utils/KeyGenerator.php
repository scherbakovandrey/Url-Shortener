<?php

namespace App\Utils;

/**
 * This class is used to generate random 6-character string 
 */
class KeyGenerator
{
    public static function generate(): string
    {
        $alphabetAndDigits = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $key = '';
        for ($i = 0; $i < 6; $i++) {
            $key .= $alphabetAndDigits[mt_rand(0, 61)];
        }
        return $key;
    }
}