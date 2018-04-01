<?php

namespace App\Utils;

/**
 * This class is used to format the URL.
 */
class UrlFormatter
{
    const CHARS_LIMIT = 80;

    public static function format(string $url): string
    {
        if (strlen($url) > UrlFormatter::CHARS_LIMIT) {
            return substr($url, 0, UrlFormatter::CHARS_LIMIT) . '...';
        } else {
            return $url;
        }
    }
}