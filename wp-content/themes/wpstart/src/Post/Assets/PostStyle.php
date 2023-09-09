<?php

declare(strict_types=1);

namespace WPStart\Post\Assets;

use WPStart\Framework\Assets\Contracts\Style;

/**
 * The post style.
 *
 * @unreleased
 */
class PostStyle extends Style
{
    /**
     * {@inheritDoc}
     *
     * @unreleased
     */
    public function getContexts(): array
    {
        return ['global'];
    }

    /**
     * {@inheritDoc}
     *
     * @unreleased
     */
    public function getHandle(): string
    {
        return 'wpstart/post';
    }

    /**
     * {@inheritDoc}
     *
     * @unreleased
     */
    public function getPath(): string
    {
        return 'client/postStyle.css';
    }
}
