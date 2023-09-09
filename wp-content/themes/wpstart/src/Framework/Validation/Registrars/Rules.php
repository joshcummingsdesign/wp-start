<?php

declare(strict_types=1);

namespace WPStart\Framework\Validation\Registrars;

use InvalidArgumentException;
use WPStart\Framework\Validation\Rules\Boolean;
use WPStart\Framework\Validation\Rules\StripHTML;
use WPStart\Vendor\StellarWP\Validation\Contracts\ValidationRule;
use WPStart\Vendor\StellarWP\Validation\ValidationRulesRegistrar;

use function WPStart\Framework\ServiceContainer\app;

/**
 * Validation rules registrar.
 *
 * @unreleased
 */
class Rules
{
    /**
     * Rules registry.
     *
     * @unreleased
     *
     * @var string[] Array of fully-qualified ValidationRule class names.
     */
    private array $rules = [
        Boolean::class,
        StripHTML::class,
    ];

    /**
     * Register rules.
     *
     * @unreleased
     */
    public function register(): void
    {
        foreach ($this->rules as $rule) {
            if ( ! is_subclass_of($rule, ValidationRule::class)) {
                throw new InvalidArgumentException("$rule must extend " . ValidationRule::class);
            }

            /** @var ValidationRulesRegistrar $instance */
            $instance = app(ValidationRulesRegistrar::class);
            $instance->register($rule);
        }
    }
}
