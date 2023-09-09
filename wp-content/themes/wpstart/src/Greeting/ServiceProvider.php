<?php

declare(strict_types=1);

namespace WPStart\Greeting;

use WPStart\Framework\Api\Registrars\ApiRoutes;
use WPStart\Framework\ServiceProviders\Contracts\ServiceProvider as ServiceProviderContract;
use WPStart\Greeting\Routes\Greeting;

use function WPStart\Framework\ServiceContainer\app;

/**
 * The greeting service provider.
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
        $this->registerApiRoutes();
    }

    /**
     * Register API routes.
     *
     * @unreleased
     */
    private function registerApiRoutes(): void
    {
        /** @var ApiRoutes $registrar */
        $registrar = app(ApiRoutes::class);

        $registrar->add([
            Greeting::class,
        ]);
    }
}
