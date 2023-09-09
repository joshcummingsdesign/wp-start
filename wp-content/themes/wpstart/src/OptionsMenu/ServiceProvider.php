<?php

declare(strict_types=1);

namespace WPStart\OptionsMenu;

use WPStart\Framework\CustomFields\Registrars\FieldGroups;
use WPStart\Framework\ServiceProviders\Contracts\ServiceProvider as ServiceProviderContract;
use WPStart\OptionsMenu\FieldGroups\OptionsMenu;

use function WPStart\Framework\ServiceContainer\app;

/**
 * The options menu service provider.
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
        $this->registerCustomFields();
    }

    /**
     * Register custom fields.
     *
     * @unreleased
     */
    private function registerCustomFields(): void
    {
        /** @var FieldGroups $registry */
        $registry = app(FieldGroups::class);

        $registry->add([
            OptionsMenu::class,
        ]);
    }
}
