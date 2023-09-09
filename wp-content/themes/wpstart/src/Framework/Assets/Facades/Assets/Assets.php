<?php

declare(strict_types=1);

namespace WPStart\Framework\Assets\Facades\Assets;

use WPStart\Framework\Facades\Facade;

/**
 * Assets facade.
 *
 * @unreleased
 *
 * @method static string getBuildDirectory()
 * @method static string getBuildDirectoryUri()
 * @method static string getBuildDirectoryPath()
 * @method static string getAssetMetaPath(string $assetPath)
 */
class Assets extends Facade
{
    /**
     * {@inheritDoc}
     *
     * @unreleased
     */
    protected function getFacadeAccessor(): string
    {
        return AssetsFacade::class;
    }
}
