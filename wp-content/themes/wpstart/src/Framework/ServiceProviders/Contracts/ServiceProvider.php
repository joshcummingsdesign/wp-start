<?php

declare(strict_types=1);

namespace WPStart\Framework\ServiceProviders\Contracts;

/**
 * The service provider contract.
 *
 * @unreleased
 */
abstract class ServiceProvider
{
    /**
     * Registers the Service Provider within the application. Use this to
     * bind anything to the Service Container. This prepares the service.
     *
     * @unreleased
     */
    abstract public function register(): void;

    /**
     * Bootstraps the service after all the services have been registered.
     * The importance of this is that any cross service dependencies should be
     * resolved by this point, so it should be safe to bootstrap the service.
     *
     * @unreleased
     */
    abstract public function boot(): void;
}
