<?php

declare(strict_types=1);

namespace WPStart\Greeting\Routes;

use WP_REST_Server;
use WPStart\Framework\Api\Contracts\ApiRoute;
use WPStart\Framework\Api\DataTransferObjects\RouteArgs;
use WPStart\Greeting\Controllers\Greeting as Controller;

/**
 * The greeting route.
 *
 * @unreleased
 */
class Greeting extends ApiRoute
{
    /**
     * The controller instance.
     *
     * @unreleased
     */
    private Controller $controller;

    /**
     * @unreleased
     */
    public function __construct(Controller $controller)
    {
        $this->controller = $controller;
    }

    /**
     * {@inheritDoc}
     *
     * @unreleased
     */
    public function getRoute(): string
    {
        return '/greeting';
    }

    /**
     * {@inheritDoc}
     *
     * @unreleased
     */
    public function getArgs(): RouteArgs
    {
        return new RouteArgs(
            methods: WP_REST_Server::READABLE,
            callback: [$this->controller, 'greet'],
        );
    }
}
