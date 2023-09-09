<?php

declare(strict_types=1);

namespace WPStart;

use InvalidArgumentException;
use WPStart\Auth\ServiceProvider as AuthServiceProvider;
use WPStart\Blocks\ServiceProvider as BlocksServiceProvider;
use WPStart\Framework\Api\ServiceProvider as ApiServiceProvider;
use WPStart\Framework\Assets\ServiceProvider as AssetsServiceProvider;
use WPStart\Framework\Console\ServiceProvider as ConsoleServiceProvider;
use WPStart\Framework\CustomFields\ServiceProvider as CustomFieldsServiceProvider;
use WPStart\Framework\Migrations\ServiceProvider as MigrationsServiceProvider;
use WPStart\Framework\ServiceProviders\Contracts\ServiceProvider;
use WPStart\Framework\Validation\ServiceProvider as ValidationServiceProvider;
use WPStart\Greeting\ServiceProvider as GreetingServiceProvider;
use WPStart\OptionsMenu\ServiceProvider as OptionsMenuServiceProvider;
use WPStart\Post\ServiceProvider as PostServiceProvider;

/**
 * The main theme class.
 *
 * @unreleased
 */
class Main
{
    /**
     * Make sure the providers are loaded only once.
     */
    private bool $providersLoaded = false;

    /**
     * Array of Service Providers to load.
     *
     * @var string[]
     */
    private array $serviceProviders = [
        ApiServiceProvider::class,
        AssetsServiceProvider::class,
        AuthServiceProvider::class,
        BlocksServiceProvider::class,
        CustomFieldsServiceProvider::class,
        GreetingServiceProvider::class,
        MigrationsServiceProvider::class,
        OptionsMenuServiceProvider::class,
        PostServiceProvider::class,
        ValidationServiceProvider::class,
        ConsoleServiceProvider::class, // Must be last
    ];

    /**
     * Bootstrap the theme.
     *
     * @unreleased
     */
    public function boot(): void
    {
        $this->defineConstants();
        $this->loadServiceProviders();
    }

    /**
     * Define theme constants.
     *
     * @unreleased
     */
    private function defineConstants(): void
    {
        /**
         * Theme Version.
         *
         * @unreleased
         */
        define('WPSTART_THEME_VERSION', wp_get_theme()->get('Version'));
    }

    /**
     * Load all the service providers to bootstrap
     * the various parts of the application.
     *
     * @unreleased
     */
    private function loadServiceProviders(): void
    {
        if ($this->providersLoaded) {
            return;
        }

        $providers = [];

        foreach ($this->serviceProviders as $serviceProvider) {
            if ( ! is_subclass_of($serviceProvider, ServiceProvider::class)) {
                throw new InvalidArgumentException("$serviceProvider must extend " . ServiceProvider::class);
            }

            /** @var ServiceProvider $serviceProvider */
            $serviceProvider = new $serviceProvider();

            $serviceProvider->register();

            $providers[] = $serviceProvider;
        }

        foreach ($providers as $serviceProvider) {
            $serviceProvider->boot();
        }

        $this->providersLoaded = true;
    }
}
