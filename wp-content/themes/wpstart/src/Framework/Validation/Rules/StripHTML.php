<?php

declare(strict_types=1);

namespace WPStart\Framework\Validation\Rules;

use Closure;
use WPStart\Vendor\StellarWP\Validation\Contracts\Sanitizer;
use WPStart\Vendor\StellarWP\Validation\Contracts\ValidationRule;

/**
 * @unreleased
 */
class StripHTML implements ValidationRule, Sanitizer
{
    /**
     * @inheritDoc
     *
     * @unreleased
     */
    public static function id(): string
    {
        return 'striphtml';
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
    public function sanitize($value): string
    {
        return sanitize_text_field($value);
    }

    /**
     * @inheritDoc
     *
     * @unreleased
     */
    public function __invoke($value, Closure $fail, string $key, array $values): void
    {
    }
}
