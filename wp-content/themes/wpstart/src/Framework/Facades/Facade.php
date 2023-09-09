<?php

declare(strict_types=1);

namespace WPStart\Framework\Facades;

use function WPStart\Framework\ServiceContainer\app;

/**
 * Class Facade
 *
 * This class provides a way of taking a normal instance class and creating a static
 * facade out of it. It does it in such a way, though, that the facade is still mockable.
 * It does this by instantiating the decorated class through the Service Container (SC).
 * So by injecting a mock singleton of the decorated class in the SC, it can be mocked.
 *
 * To use this, simply make a new facade class which extends
 * this once, then implement getFacadeAccessor and return the
 * class to be decorated, for example: return MyClass::class;
 *
 * To help the IDE, take the methods from the decorated class and
 * add them your class docblock. So if Repository had an insert
 * method, you would add "@method static Model insert()" to the top.
 *
 * @unreleased
 */
abstract class Facade
{
    /**
     * Static helper for calling the facade methods.
     *
     * @unreleased
     */
    public static function __callStatic(string $name, array $arguments = []): mixed
    {
        $staticInstance = app(static::class);
        $accessorClass = $staticInstance->getFacadeAccessor();

        return app($accessorClass)->$name(...$arguments);
    }

    /**
     * Retrieves the fully qualified class name or alias for the class being decorated.
     *
     * @unreleased
     */
    abstract protected function getFacadeAccessor(): string;
}
