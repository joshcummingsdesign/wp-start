<?php

declare(strict_types=1);

namespace WPStart\Framework\Api\Registrars;

use InvalidArgumentException;
use WPStart\Framework\Api\Contracts\ApiRoute;

use function WPStart\Framework\ServiceContainer\app;

/**
 * ApiRoutes registrar.
 *
 * @unreleased
 */
class ApiRoutes
{
    /**
     * ApiRoutes registry.
     *
     * @unreleased
     *
     * @var string[] Array of fully-qualified ApiRoute class names.
     */
    private array $apiRoutes = [];

    /**
     * Get all the registered API routes.
     *
     * @unreleased
     *
     * @return string[]
     */
    public function getAll(): array
    {
        return $this->apiRoutes;
    }

    /**
     * Add an API route to the registry.
     *
     * @unreleased
     *
     * @param string $apiRoute Fully-qualified ApiRoute class name.
     */
    public function addOne(string $apiRoute): void
    {
        if ( ! is_subclass_of($apiRoute, ApiRoute::class)) {
            throw new InvalidArgumentException("$apiRoute must extend " . ApiRoute::class);
        }

        $this->apiRoutes[] = $apiRoute;
    }

    /**
     * Add API routes to the registry.
     *
     * @unreleased
     *
     * @param string[] $apiRoutes Array of fully-qualified ApiRoute class names.
     */
    public function add(array $apiRoutes): void
    {
        foreach ($apiRoutes as $apiRoute) {
            $this->addOne($apiRoute);
        }
    }

    /**
     * Register commands.
     *
     * @unreleased
     */
    public function register(string $namespace): void
    {
        $apiRoutes = $this->getAll();

        foreach ($apiRoutes as $apiRoute) {
            /** @var ApiRoute $instance */
            $instance = app($apiRoute);

            register_rest_route(
                $namespace,
                $instance->getRoute(),
                (array)$instance->getArgs(),
            );
        }
    }
}
