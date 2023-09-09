<?php

declare(strict_types=1);

namespace WPStart\Framework\CustomFields;

use WPStart\Framework\Core\Hooks;
use WPStart\Framework\CustomFields\Actions\BootCarbonFields;
use WPStart\Framework\CustomFields\Registrars\FieldGroups;
use WPStart\Framework\ServiceProviders\Contracts\ServiceProvider as ServiceProviderContract;

/**
 * CustomFields service provider.
 *
 * @unreleased
 */
class ServiceProvider extends ServiceProviderContract
{
    /**
     * {@inheritDoc}
     *
     * @unreleased
     */
    public function register(): void
    {
    }

    /**
     * {@inheritDoc}
     *
     * @unreleased
     */
    public function boot(): void
    {
        Hooks::addAction('after_setup_theme', BootCarbonFields::class);
        Hooks::addAction('carbon_fields_register_fields', FieldGroups::class, 'register');
    }
}
