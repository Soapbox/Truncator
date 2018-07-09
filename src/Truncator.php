<?php

namespace SoapBox\Truncator;

class Truncator
{
    /**
     * Determine if the given text should be truncated to the end of a word
     *
     * @param string $test
     * @param int $maxLength
     *
     * @return bool
     */
    private static function shouldTruncateOnWord(string $text, int $maxLength): bool
    {
        $text = mb_substr($text, $maxLength);
        return mb_strpos($text, ' ') !== 0;
    }

    /**
     * Truncate the given text at the end of a word
     *
     * @param string $test
     * @param int $maxLength
     *
     * @return string
     */
    private static function truncateOnWord(string $text, int $maxLength): string
    {
        $text = self::truncateToLength($text, $maxLength);

        if (false !== $index = mb_strrpos($text, ' ')) {
            return mb_substr($text, 0, $index);
        }

        return $text;
    }

    /**
     * Truncate the given text to the given length
     *
     * @param string $text
     * @param int $length
     *
     * @return string
     */
    private static function truncateToLength(string $text, int $length): string
    {
        return mb_substr($text, 0, $length);
    }

    /**
     * Truncate a string and append the string with the given suffix if it has been truncated
     *
     * @param string $text
     * @param int $maxLength
     * @param string $suffix
     *
     * @return string
     */
    public static function truncate(string $text, int $maxLength, string $suffix = '...'): string
    {
        $result = $text;

        if (mb_strlen($text) > $maxLength) {
            if (self::shouldTruncateOnWord($text, $maxLength)) {
                $result = self::truncateOnWord($text, $maxLength);
            } else {
                $result = self::truncateToLength($text, $maxLength);
            }

            $result .= $suffix;
        }

        return $result;
    }
}
