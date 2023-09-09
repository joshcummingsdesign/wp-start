<?php

declare(strict_types=1);

namespace WPStart\Framework\ServiceContainer;

use DI\Container;

/**
 * The app's service container helper function.
 *
 * @unreleased
 *
 * @param ?string $abstract Selector for data to retrieve from the service container.
 *
 * @return object The service container or container entry.
 */
function app(?string $abstract = null): object
{
    static $instance = null;

    if ($instance === null) {
        $instance = new Container();
    }

    if ($abstract !== null) {
        return $instance->get($abstract);
    }

    return $instance;
}
