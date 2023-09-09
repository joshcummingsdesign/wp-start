<?php

declare(strict_types=1);

namespace WPStart\Helpers\Support\Facades\Str;

/**
 * Str facade.
 *
 * @unreleased
 */
class StrFacade
{
    /**
     * Generate a UUID.
     *
     * @unreleased
     */
    public function generateUuid(): string
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            // 32 bits for "time_low"
            random_int(0, 0xffff),
            random_int(0, 0xffff),
            // 16 bits for "time_mid"
            random_int(0, 0xffff),
            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            random_int(0, 0x0fff) | 0x4000,
            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            random_int(0, 0x3fff) | 0x8000,
            // 48 bits for "node"
            random_int(0, 0xffff),
            random_int(0, 0xffff),
            random_int(0, 0xffff)
        );
    }

    /**
     * Check whether a UUID is valid.
     *
     * @unreleased
     */
    public function isValidUuid(string $uuid): bool
    {
        return preg_match('/[0-9a-fA-F]{4}[0-9a-fA-F]{4}-[0-9a-fA-F]{4}-[0-9a-fA-F]{4}-[0-9a-fA-F]{4}-[0-9a-fA-F]{4}[0-9a-fA-F]{4}[0-9a-fA-F]{4}/',
                $uuid) === 1;
    }

    /**
     * Slugify a string.
     *
     * @unreleased
     */
    public function slugify(string $str, string $prefix = ''): string
    {
        $prefix = empty($prefix) ? '' : "$prefix-";

        // Convert anything that's not a letter or number to a hyphen.
        $filtered = preg_replace('/[^\p{L}\p{N}]+/u', '-', $str);
        // Convert to lowercase.
        $filtered = strtolower($filtered);
        // Remove any remaining leading or trailing hyphens.
        $filtered = preg_replace('/(^-+)|(-+$)/', '', $filtered);

        return $prefix . $filtered;
    }

    /**
     * Trim text x number of letters to terminal punctuation.
     *
     * @unreleased
     */
    public function trimSentence(string $content, int $letterCount): string
    {
        preg_match("/[.!?]/", $content, $matches, PREG_OFFSET_CAPTURE, $letterCount - 1);

        $index = $matches && count($matches) > 0 && count($matches[0]) > 1 ? $matches[0][1] : null;

        // If no terminal punctuation is found, return the whole string
        if ($index === null) {
            return $content;
        }

        return substr($content, 0, $index + 1);
    }
}
