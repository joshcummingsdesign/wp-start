<?php

declare(strict_types=1);

namespace WPStart\Blocks;

use WPStart\Blocks\Actions\AddBlockCategories;
use WPStart\Blocks\Registrars\Blocks;
use WPStart\Framework\Core\Hooks;
use WPStart\Framework\ServiceProviders\Contracts\ServiceProvider as ServiceProviderContract;

/**
 * The blocks service provider.
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
        Hooks::addAction('init', Blocks::class, 'register');
        Hooks::addAction('enqueue_block_editor_assets', Blocks::class, 'enqueueEditorAssets');
        Hooks::addAction('enqueue_block_assets', Blocks::class, 'enqueueAssets');
        Hooks::addFilter('block_categories_all', AddBlockCategories::class);
    }
}
