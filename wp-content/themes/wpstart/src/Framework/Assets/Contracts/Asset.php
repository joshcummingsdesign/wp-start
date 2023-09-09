<?php

declare(strict_types=1);

namespace WPStart\Framework\Assets\Contracts;

use WPStart\Framework\Assets\Controllers\Assets as AssetsController;
use WPStart\Framework\Assets\Facades\Assets\Assets;

/**
 * The asset contract.
 *
 * @unreleased
 */
abstract class Asset
{
    /**
     * The asset meta.
     *
     * @unreleased
     *
     * @var array<string, string> [ 'dependencies' => string, 'version' => string ]
     */
    private ?array $assetMeta;

    /**
     * Get the asset contexts.
     *
     * @see AssetsController::enqueueScripts()
     * @see AssetsController::enqueueStyles()
     *
     * @unreleased
     *
     * @return string[] Array of contexts.
     */
    abstract public function getContexts(): array;

    /**
     * Get the asset handle.
     *
     * @unreleased
     */
    abstract public function getHandle(): string;

    /**
     * Get the path relative to the build directory.
     *
     * @unreleased
     */
    abstract public function getPath(): string;

    /**
     * Enqueue the asset.
     *
     * @unreleased
     */
    abstract public function enqueue(): void;

    /**
     * Get asset dependencies.
     *
     * @unreleased
     */
    public function getDependencies(bool $withAssetMeta = false): array
    {
        if ( ! $withAssetMeta) {
            return $this->getAdditionalDependencies();
        }

        $asset = $this->getAssetMeta();

        return array_merge($asset['dependencies'], $this->getAdditionalDependencies());
    }

    /**
     * Get additional dependencies outside of assets file.
     *
     * @unreleased
     *
     * @return string[] Additional dependencies
     */
    public function getAdditionalDependencies(): array
    {
        return [];
    }

    /**
     * Get asset version.
     *
     * @unreleased
     */
    public function getVersion(): string
    {
        $asset = $this->getAssetMeta();

        return $asset['version'];
    }

    /**
     * Get the asset URI.
     *
     * @unreleased
     */
    public function getAssetUri(): string
    {
        return Assets::getBuildDirectoryUri() . '/' . $this->getPath();
    }

    /**
     * Get the asset path relative to the theme directory.
     *
     * @unreleased
     */
    public function getAssetPath(): string
    {
        return Assets::getBuildDirectoryPath() . '/' . $this->getPath();
    }

    /**
     * Get the asset meta.
     *
     * @return array<string, string|string[]> [ 'dependencies' => string[], 'version' => string ]
     */
    private function getAssetMeta(): array
    {
        if ( ! isset($this->assetMeta)) {
            $this->assetMeta = require Assets::getAssetMetaPath($this->getAssetPath());
        }

        return $this->assetMeta;
    }
}
