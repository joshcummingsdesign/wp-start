<?php

declare(strict_types=1);

namespace WPStart\Framework\ViewModels\Contracts;

/**
 * The view model contract.
 *
 * @unreleased
 */
abstract class ViewModel
{
    /**
     * Build the view model instance.
     *
     * @unreleased
     */
    abstract public static function build(): self;
}
