<?php

declare(strict_types=1);

namespace WPStart\Framework\Validation;

use WPStart\Framework\ServiceContainer\ServiceContainer;
use WPStart\Framework\ServiceProviders\Contracts\ServiceProvider as ServiceProviderContract;
use WPStart\Framework\Validation\Registrars\Rules;
use WPStart\Vendor\StellarWP\Validation\Config;

use function WPStart\Framework\ServiceContainer\app;

class ServiceProvider extends ServiceProviderContract
{
    /**
     * {@inheritDoc}
     *
     * @unreleased
     */
    public function register(): void
    {
        Config::setServiceContainer(new ServiceContainer());
        Config::setHookPrefix('give_');
        Config::initialize();
    }

    /**
     * {@inheritDoc}
     *
     * @unreleased
     */
    public function boot(): void
    {
        $this->registerRules();
    }

    /**
     * Register validation rules.
     *
     * @unreleased
     */
    private function registerRules(): void
    {
        /** @var Rules $rules */
        $rules = app(Rules::class);
        $rules->register();
    }
}
