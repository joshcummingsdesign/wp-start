<?php

declare(strict_types=1);

namespace WPStart\Framework\ServerSideRenderer\Repositories;

use Exception;
use Spatie\Ssr\Engines\Node;
use Spatie\Ssr\Renderer;
use WPStart\Framework\Assets\Facades\Assets\Assets;
use WPStart\Framework\Log\Facades\Log;

/**
 * Server-side render repository.
 *
 * @unreleased
 */
class ServerSideRenderer
{
    private Node $engine;
    private Renderer $renderer;

    /**
     * Get debug mode.
     *
     * @unreleased
     */
    public function isDebugMode(): bool
    {
        return defined('WPSTART_SSR_DEBUG') && WPSTART_SSR_DEBUG;
    }

    /**
     * Get SSR engine.
     *
     * @unreleased
     */
    public function getEngine(): Node
    {
        if ( ! isset($this->engine)) {
            $this->engine = new Node(WPSTART_NODE_PATH, WPSTART_NODE_TEMP_PATH);
        }

        return $this->engine;
    }

    /**
     * Get SSR renderer.
     *
     * @unreleased
     */
    public function getRenderer(): Renderer
    {
        if ( ! isset($this->renderer)) {
            $renderer = new Renderer($this->getEngine());
            $this->renderer = $renderer->debug($this->isDebugMode());
        }

        return $this->renderer;
    }

    /**
     * Server-side render.
     *
     * @unreleased
     *
     * @param string $path    The entry path relative to the build directory.
     * @param array  $context The data to pass in as a `context` object.
     *
     * @return string The output.
     */
    public function render(string $path, array $context): string
    {
        $buildPath = Assets::getBuildDirectoryPath() . '/server/' . $path;
        $renderer = $this->getRenderer();

        try {
            return $renderer->entry($buildPath)->context($context)->render();
        } catch (Exception $e) {
            // Fail silently, but log the error
            if ($this->isDebugMode()) {
                Log::debug($e->getMessage(), [
                    'path' => $path,
                    'context' => $context,
                ]);
            }

            return '';
        }
    }
}
