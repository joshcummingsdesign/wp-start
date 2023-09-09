<?php

declare(strict_types=1);

namespace WPStart\Framework\Assets\Contracts;

/**
 * The style contract.
 *
 * @unreleased
 */
abstract class Style extends Asset
{
    /**
     * The media for which this stylesheet has been defined. Must
     * return a media type like 'all', 'print' and 'screen', or media
     * queries like '(orientation: portrait)' and '(max-width: 640px)'.
     *
     * @unreleased
     */
    protected function getMedia(): string
    {
        return 'all';
    }

    /**
     * {@inheritDoc}
     *
     * @unreleased
     */
    public function enqueue(): void
    {
        wp_enqueue_style(
            $this->getHandle(),
            $this->getAssetUri(),
            $this->getDependencies(),
            $this->getVersion(),
            $this->getMedia()
        );
    }
}
