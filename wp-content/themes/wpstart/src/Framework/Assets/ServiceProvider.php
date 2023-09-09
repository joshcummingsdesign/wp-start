<?php

declare(strict_types=1);

namespace WPStart\Framework\Assets;

use WPStart\Framework\Assets\Controllers\Assets;
use WPStart\Framework\Assets\Registrars\Assets as Registrar;
use WPStart\Framework\Core\Hooks;
use WPStart\Framework\ServiceProviders\Contracts\ServiceProvider as ServiceProviderContract;

use function WPStart\Framework\ServiceContainer\app;

class ServiceProvider extends ServiceProviderContract
{
    /**
     * {@inheritDoc}
     *
     * @unreleased
     */
    public function register(): void
    {
    }

    /**
     * {@inheritDoc}
     *
     * @unreleased
     */
    public function boot(): void
    {
        $this->enqueueScripts();

        Hooks::addAction('wp_enqueue_scripts', Assets::class, 'enqueueScripts');
        Hooks::addAction('wp_enqueue_scripts', Assets::class, 'enqueueStyles');
        Hooks::addAction('admin_enqueue_scripts', Assets::class, 'adminEnqueueScripts');
        Hooks::addAction('admin_enqueue_scripts', Assets::class, 'adminEnqueueStyles');
    }

    /**
     * Enqueue scripts.
     *
     * @unreleased
     */
    private function enqueueScripts(): void
    {
        /** @var Registrar $assets */
        $assets = app(Registrar::class);

        $assets->addScripts([
            Runtime::class,
        ]);
    }
}
