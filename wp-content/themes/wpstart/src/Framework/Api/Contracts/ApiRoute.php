<?php

declare(strict_types=1);

namespace WPStart\Framework\Api\Contracts;

use WPStart\Framework\Api\DataTransferObjects\RouteArgs;

/**
 * The API route abstract class.
 *
 * @unreleased
 */
abstract class ApiRoute
{
    /**
     * Get the route.
     *
     * @unreleased
     */
    abstract public function getRoute(): string;

    /**
     * Get the route args.
     *
     * @unreleased
     */
    abstract public function getArgs(): RouteArgs;
}
