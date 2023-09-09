<?php

declare(strict_types=1);

namespace WPStart\Framework\Assets;

use WPStart\Framework\Assets\Contracts\Script;

/**
 * The webpack runtime script for local development.
 *
 * @unreleased
 */
class Runtime extends Script
{
    /**
     * {@inheritDoc}
     *
     * @unreleased
     */
    public function getContexts(): array
    {
        return ['admin', 'hot'];
    }

    /**
     * {@inheritDoc}
     *
     * @unreleased
     */
    public function getHandle(): string
    {
        return 'wpstart/runtime';
    }

    /**
     * {@inheritDoc}
     *
     * @unreleased
     */
    public function getPath(): string
    {
        return 'client/runtime.js';
    }
}
