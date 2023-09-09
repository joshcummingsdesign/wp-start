<?php

declare(strict_types=1);

namespace WPStart\Framework\Log\Facades;

use WPStart\Framework\Facades\Facade;

/**
 * Log facade.
 *
 * @unreleased
 *
 * @method static void debug(string $message, array $context = [])
 * @method static void info(string $message, array $context = [])
 * @method static void warning(string $message, array $context = [])
 * @method static void error(string $message, array $context = [])
 * @method static void fatal(string $message, array $context = [])
 */
class Log extends Facade
{
    /**
     * {@inheritDoc}
     *
     * @unreleased
     */
    protected function getFacadeAccessor(): string
    {
        return LogFacade::class;
    }
}
