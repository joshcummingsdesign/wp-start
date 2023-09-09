<?php

declare(strict_types=1);

namespace WPStart\Framework\Assets\DataTransferObjects;

/**
 * @unreleased
 */
class AssetContext
{
    public function __construct(
        /** @var string[] $scripts Array of fully-qualified Script class names. */
        public array $scripts,
        /** @var string[] $styles Array of fully-qualified Style class names. */
        public array $styles,
    ) {
    }
}
