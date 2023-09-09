<?php

declare(strict_types=1);

namespace WPStart\Framework\CustomFields\Actions;

use Carbon_Fields\Carbon_Fields;

/**
 * Boot carbon fields.
 *
 * @unreleased
 */
class BootCarbonFields
{
    public function __invoke(): void
    {
        Carbon_Fields::boot();
    }
}
