<?php

declare(strict_types=1);

namespace WPStart\Framework\Assets\Controllers;

use WPStart\Framework\Assets\Contracts\Asset;
use WPStart\Framework\Assets\Facades\Assets\Assets as AssetsFacade;
use WPStart\Framework\Assets\Registrars\Assets as Registrar;
use WPStart\Framework\CustomFields\Repositories\CustomFields;

use function WPStart\Framework\ServiceContainer\app;

/**
 * Assets controller.
 *
 * @unreleased
 */
class Assets
{
    /**
     * Enqueued assets.
     *
     * @var array<string, Asset> [ Fully-qualified Asset class name => Asset ]
     */
    private array $enqueued = [];

    /**
     * Admin enqueued assets.
     *
     * @var array<string, Asset> [ Fully-qualified Asset class name => Asset ]
     */
    private array $adminEnqueued = [];

    /**
     * The assets registrar.
     *
     * @unreleased
     */
    private Registrar $registrar;

    /**
     * @unreleased
     */
    public function __construct(Registrar $registrar)
    {
        $this->registrar = $registrar;
    }

    /**
     * Get contexts.
     *
     * @unreleased
     *
     * @return array<string, callable> [ $context => isContext(): bool ]
     */
    public function getContexts(): array
    {
        return [
            'global' => static fn() => true,
            'hot' => [$this, 'isWebpackHot'],
            'post' => static fn() => is_admin() || is_single(),
            'blog-archive' => static fn() => is_home() || is_archive(),
            'page' => static fn() => ! is_front_page() && is_page(),
            'search-results' => static fn() => is_search(),
            'home' => static fn() => is_front_page(),
        ];
    }

    /**
     * See if we're running webpack dev server with `--hot`.
     *
     * @unreleased
     */
    private function isWebpackHot(): bool
    {
        return wp_get_environment_type() === 'local'
               && defined('SCRIPT_DEBUG')
               && SCRIPT_DEBUG === true
               && file_exists(AssetsFacade::getBuildDirectoryPath() . '/client/runtime.js');
    }

    /**
     * Conditionally enabled global post styles.
     *
     * @unreleased
     */
    private function postStylesEnabled(): bool
    {
        /** @var CustomFields $customFields */
        $customFields = app(CustomFields::class);

        if (is_admin() || is_single()) {
            return true;
        }

        return (bool)$customFields->getPostMeta('global_post_styles_enabled', get_the_ID());
    }

    /**
     * Conditionally enabled global page styles.
     *
     * @unreleased
     */
    private function pageStylesEnabled(): bool
    {
        /** @var CustomFields $customFields */
        $customFields = app(CustomFields::class);

        if (is_singular('tutorial') || is_singular('doc')) {
            return true;
        }

        return is_page() && $customFields->getPostMeta('global_post_styles_enabled', get_the_ID());
    }

    /**
     * Get the registrar.
     *
     * @unreleased
     */
    public function getRegistrar(): Registrar
    {
        return $this->registrar;
    }

    /**
     * Enqueue asset if it is not enqueued already.
     *
     * @unreleased
     *
     * @param string $asset Fully-qualified Asset class name.
     */
    public function maybeEnqueue(string $asset): void
    {
        if ( ! isset($this->enqueued[$asset])) {
            $this->enqueued[$asset] = app($asset);
            $this->enqueued[$asset]->enqueue();
        }
    }

    /**
     * Admin enqueue asset if it is not enqueued already.
     *
     * @unreleased
     *
     * @param string $asset Fully-qualified Asset class name.
     */
    public function maybeAdminEnqueue(string $asset): void
    {
        if ( ! isset($this->adminEnqueued[$asset])) {
            $this->adminEnqueued[$asset] = app($asset);

            // If hot is set in context, check isWebpackHot
            if ( ! $this->isWebpackHot() && in_array('hot', $this->adminEnqueued[$asset]->getContexts(), true)) {
                return;
            }

            $this->adminEnqueued[$asset]->enqueue();
        }
    }

    /**
     * Enqueue scripts.
     *
     * @unreleased
     */
    public function enqueueScripts(): void
    {
        $contexts = $this->getContexts();
        $assets = $this->getRegistrar()->get();

        foreach ($contexts as $context => $isContext) {
            if ($context === 'admin') {
                continue;
            }

            if (isset($assets[$context]) && $isContext()) {
                foreach ($assets[$context]->scripts as $script) {
                    $this->maybeEnqueue($script);
                }
            }
        }
    }

    /**
     * Enqueue styles.
     *
     * @unreleased
     */
    public function enqueueStyles(): void
    {
        $contexts = $this->getContexts();
        $assets = $this->getRegistrar()->get();

        foreach ($contexts as $context => $isContext) {
            if ($context === 'admin') {
                continue;
            }

            if (isset($assets[$context]) && $isContext()) {
                foreach ($assets[$context]->styles as $style) {
                    $this->maybeEnqueue($style);
                }
            }
        }
    }

    /**
     * Admin enqueue scripts.
     *
     * @unreleased
     */
    public function adminEnqueueScripts(): void
    {
        $assets = $this->getRegistrar()->get();

        foreach ($assets['admin']->scripts as $script) {
            $this->maybeAdminEnqueue($script);
        }
    }

    /**
     * Admin enqueue styles.
     *
     * @unreleased
     */
    public function adminEnqueueStyles(): void
    {
        $assets = $this->getRegistrar()->get();

        foreach ($assets['admin']->styles as $style) {
            $this->maybeAdminEnqueue($style);
        }
    }
}
