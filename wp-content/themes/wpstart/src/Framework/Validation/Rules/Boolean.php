<?php

declare(strict_types=1);

namespace WPStart\Framework\Validation\Rules;

use Closure;
use WPStart\Vendor\StellarWP\Validation\Contracts\Sanitizer;
use WPStart\Vendor\StellarWP\Validation\Contracts\ValidationRule;

/**
 * @unreleased
 */
class Boolean implements ValidationRule, Sanitizer
{
    /**
     * @inheritDoc
     *
     * @unreleased
     */
    public static function id(): string
    {
        return 'bool';
    }

    /**
     * @inheritDoc
     *
     * @unreleased
     */
    public static function fromString(string $options = null): ValidationRule
    {
        return new self();
    }

    /**
     * @inheritDoc
     *
     * @unreleased
     */
    public function sanitize($value): bool
    {
        return $value === 'true';
    }

    /**
     * @inheritDoc
     *
     * @unreleased
     */
    public function __invoke($value, Closure $fail, string $key, array $values): void
    {
        if ($value !== 'true' && $value !== 'false') {
            $fail(sprintf(__('%s must be a bool', '%TEXTDOMAIN%'), '{field}'));
        }
    }
}
