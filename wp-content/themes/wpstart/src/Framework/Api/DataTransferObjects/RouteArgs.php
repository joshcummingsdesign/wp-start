<?php

declare(strict_types=1);

namespace WPStart\Framework\Api\DataTransferObjects;

/**
 * @unreleased
 */
class RouteArgs
{
    public function __construct(
        public string $methods,
        public array $callback,
        public mixed $permission_callback = null,
        public array $args = [],
    ) {
    }
}
