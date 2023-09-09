<?php

declare(strict_types=1);

namespace WPStart\Framework\Assets\Facades\Assets;

/**
 * Assets facade.
 *
 * @unreleased
 */
class AssetsFacade
{
    /**
     * Get the build directory relative to the root of the theme.
     *
     * @unreleased
     */
    public function getBuildDirectory(): string
    {
        return 'build';
    }

    /**
     * Get the build directory URI.
     *
     * @unreleased
     */
    public function getBuildDirectoryUri(): string
    {
        return get_stylesheet_directory_uri() . '/' . $this->getBuildDirectory();
    }

    /**
     * Get build directory path.
     *
     * @unreleased
     */
    public function getBuildDirectoryPath(): string
    {
        return get_stylesheet_directory() . '/' . $this->getBuildDirectory();
    }

    /**
     * Get the asset meta path.
     */
    public function getAssetMetaPath(string $assetPath): string
    {
        return preg_replace("/\.(css|js)$/", '.asset.php', $assetPath);
    }
}
