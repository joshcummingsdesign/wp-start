<?php

namespace WPStart\Framework\ServiceContainer;

use WPStart\Vendor\StellarWP\ContainerContract\ContainerInterface;

class ServiceContainer implements ContainerInterface
{
    /**
     * The service container.
     *
     * @unreleased
     */
    protected object $container;

    /**
     * @unreleased
     */
    public function __construct()
    {
        $this->container = app();
    }

    /**
     * {@inheritDoc}
     *
     * @unreleased
     */
    public function bind(string $id, mixed $implementation = null): void
    {
        $this->container->set($id, $implementation);
    }

    /**
     * {@inheritDoc}
     *
     * @unreleased
     */
    public function get(string $id): object
    {
        return $this->container->make($id);
    }

    /**
     * {@inheritDoc}
     *
     * @unreleased
     */
    public function has(string $id): bool
    {
        return $this->container->has($id);
    }

    /**
     * {@inheritDoc}
     *
     * @unreleased
     */
    public function singleton(string $id, mixed $implementation = null): void
    {
        $this->container->set($id, $implementation);
    }
}
