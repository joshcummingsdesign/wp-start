<?php

declare(strict_types=1);

namespace WPStart\Framework\Api;

use WP_REST_Controller;
use WPStart\Framework\Api\Registrars\ApiRoutes;

use function WPStart\Framework\ServiceContainer\app;

/**
 * The REST API service.
 *
 * @unreleased
 */
class Server extends WP_REST_Controller
{
    /**
     * {@inheritdoc}
     *
     * @unreleased
     */
    protected $namespace = 'wpstart/v1';

    /**
     * {@inheritDoc}
     *
     * @unreleased
     */
    public function register_routes(): void
    {
        /** @var ApiRoutes $apiRoutes */
        $apiRoutes = app(ApiRoutes::class);
        $apiRoutes->register($this->namespace);
    }
}
