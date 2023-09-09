<?php

declare(strict_types=1);

namespace WPStart\Framework\Assets\Contracts;

/**
 * The style contract.
 *
 * @unreleased
 */
abstract class Script extends Asset
{
    /**
     * Whether to enqueue the script before body instead of in the head.
     *
     * @unreleased
     */
    protected function inFooter(): bool
    {
        return false;
    }

    /**
     * {@inheritDoc}
     *
     * @unreleased
     */
    public function enqueue(): void
    {
        wp_enqueue_script(
            $this->getHandle(),
            $this->getAssetUri(),
            $this->getDependencies(true),
            $this->getVersion(),
            $this->inFooter()
        );
    }
}
