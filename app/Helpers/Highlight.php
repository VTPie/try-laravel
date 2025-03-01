<?php
namespace App\Helpers;

class Highlight
{
    public static function highlight($original, $targetWord)
    {
        if (!empty($targetWord)) {
            // /i is for case-insensitive
            // preg_quote() is for escaping characters that have special meaning in regex
            $highlightedString = preg_replace(
                '/' . preg_quote($targetWord, '/') . '/i', // convert targetWord to regex pattern
                '<span style="background-color: yellow">$0</span>',
                $original
            );
            return $highlightedString;
        }
        return $original;
    }
}