<?php

declare(strict_types=1);

namespace WPStart\Framework\Api\Facades\Api;

use WPStart\Framework\Api\Response;
use WPStart\Framework\Facades\Facade;

/**
 * Api facade.
 *
 * @unreleased
 *
 * @method static send(Response $response, bool $shouldReturn = false)
 */
class Api extends Facade
{
    /**
     * {@inheritDoc}
     *
     * @unreleased
     */
    protected function getFacadeAccessor(): string
    {
        return ApiFacade::class;
    }
}
