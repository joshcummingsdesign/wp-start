<?php

declare(strict_types=1);

namespace WPStart\Framework\CustomFields\Contracts;

/**
 * FieldGroup contract.
 *
 * @unreleased
 */
abstract class FieldGroup
{
    /**
     * Register a field group.
     *
     * @unreleased
     */
    abstract public function register(): void;
}
