<?php

declare(strict_types=1);

namespace WPStart\Post;

use WPStart\Framework\Assets\Registrars\Assets;
use WPStart\Framework\ServiceProviders\Contracts\ServiceProvider as ServiceProviderContract;
use WPStart\Post\Assets\PostStyle;

use function WPStart\Framework\ServiceContainer\app;

/**
 * The post service provider.
 *
 * @unreleased
 */
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
    }

    /**
     * Enqueue scripts.
     *
     * @unreleased
     */
    private function enqueueScripts(): void
    {
        /** @var Assets $assets */
        $assets = app(Assets::class);

        $assets->addStyles([
            PostStyle::class,
        ]);
    }
}
