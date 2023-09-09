<?php

declare(strict_types=1);

namespace WPStart\Framework\Api;

use WPStart\Framework\Core\Hooks;
use WPStart\Framework\ServiceProviders\Contracts\ServiceProvider as ServiceProviderContract;

/**
 * The API service provider.
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
        Hooks::addAction('rest_api_init', Server::class, 'register_routes');
    }
}
