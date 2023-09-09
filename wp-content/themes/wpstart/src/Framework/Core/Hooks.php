<?php

declare(strict_types=1);

namespace WPStart\Framework\Core;

use InvalidArgumentException;

use function WPStart\Framework\ServiceContainer\app;

/**
 * WordPress Hooks class.
 *
 * @unreleased
 */
class Hooks
{
    /**
     * A function which extends the WordPress add_action method to handle
     * the instantiation of a class once the action is fired. This
     * prevents the need to instantiate a class before adding it to hook.
     *
     * @unreleased
     *
     * @param string $tag          The name of the action.
     * @param string $class        The name of the class.
     * @param string $method       The name of the method.
     * @param int    $priority     A number which indicates execution order.
     * @param int    $acceptedArgs The number of arguments the method accepts.
     */
    public static function addAction(
        string $tag,
        string $class,
        string $method = '__invoke',
        int $priority = 10,
        int $acceptedArgs = 1
    ): void {
        if ( ! method_exists($class, $method)) {
            throw new InvalidArgumentException("The method $method does not exist on $class");
        }

        add_action(
            $tag,
            static function () use ($tag, $class, $method) {
                // Provide a way of disabling the hook
                if (apply_filters("give_disable_hook-$tag", false)
                    || apply_filters("give_disable_hook-$tag:$class@$method", false)) {
                    return;
                }

                $instance = app($class);

                call_user_func_array([$instance, $method], func_get_args());
            },
            $priority,
            $acceptedArgs
        );
    }

    /**
     * A function which extends the WordPress add_filter method to handle
     * the instantiation of a class once the filter is fired. This
     * prevents the need to instantiate a class before adding it to hook.
     *
     * @unreleased
     *
     * @param string $tag          The name of the filter.
     * @param string $class        The name of the class.
     * @param string $method       The name of the method.
     * @param int    $priority     A number which indicates execution order.
     * @param int    $acceptedArgs The number of arguments the method accepts.
     */
    public static function addFilter(
        string $tag,
        string $class,
        string $method = '__invoke',
        int $priority = 10,
        int $acceptedArgs = 1
    ): void {
        if ( ! method_exists($class, $method)) {
            throw new InvalidArgumentException("The method $method does not exist on $class");
        }

        add_filter(
            $tag,
            static function () use ($tag, $class, $method) {
                // Provide a way of disabling the hook
                if (apply_filters("give_disable_hook-$tag", false)
                    || apply_filters("give_disable_hook-$tag:$class@$method", false)) {
                    return func_get_arg(0);
                }

                $instance = app($class);

                return call_user_func_array([$instance, $method], func_get_args());
            },
            $priority,
            $acceptedArgs
        );
    }
}
