<?php

declare(strict_types=1);

namespace WPStart\OptionsMenu\FieldGroups;

use Carbon_Fields\Container;
use WPStart\Framework\CustomFields\Contracts\FieldGroup;

/**
 * OptionsMenu field group.
 *
 * @unreleased
 */
class OptionsMenu extends FieldGroup
{
    /**
     * {@inheritDoc}
     *
     * @unreleased
     */
    public function register(): void
    {
        Container::make('theme_options', 'Options Menu')
            ->add_fields([
                // Add custom fields here...
            ]);
    }
}
