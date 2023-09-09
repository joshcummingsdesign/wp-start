<?php

declare(strict_types=1);

namespace WPStart\Framework\Assets\Registrars;

use InvalidArgumentException;
use WPStart\Framework\Assets\Contracts\Script;
use WPStart\Framework\Assets\Contracts\Style;
use WPStart\Framework\Assets\DataTransferObjects\AssetContext;

use function WPStart\Framework\ServiceContainer\app;

/**
 * Assets registrar.
 *
 * @unreleased
 */
class Assets
{
    /**
     * Assets registry.
     *
     * @unreleased
     *
     * @var array<string, AssetContext> [ $context => AssetContext ]
     */
    private array $assets = [];

    /**
     * Get all the registered assets.
     *
     * @unreleased
     *
     * @return array<string, AssetContext> [ $context => AssetContext ]
     */
    public function get(): array
    {
        return $this->assets;
    }

    /**
     * Add a script to the registry.
     *
     * @unreleased
     *
     * @param string $script Fully-qualified Script class name.
     */
    public function addOneScript(string $script): void
    {
        if ( ! is_subclass_of($script, Script::class)) {
            throw new InvalidArgumentException("$script must extend " . Script::class);
        }

        /** @var Script $instance */
        $instance = app($script);
        $contexts = $instance->getContexts();

        foreach ($contexts as $context) {
            if ( ! isset($this->assets[$context])) {
                $this->assets[$context] = new AssetContext(
                    scripts: [],
                    styles: [],
                );
            }

            $this->assets[$context]->scripts[] = $script;
        }
    }

    /**
     * Add multiple scripts to the registry.
     *
     * @unreleased
     *
     * @param string[] $scripts Array of fully-qualified Script class names.
     */
    public function addScripts(array $scripts): void
    {
        foreach ($scripts as $script) {
            $this->addOneScript($script);
        }
    }

    /**
     * Add a style to the registry.
     *
     * @unreleased
     *
     * @param string $style Fully-qualified Style class name.
     */
    public function addOneStyle(string $style): void
    {
        if ( ! is_subclass_of($style, Style::class)) {
            throw new InvalidArgumentException("$style must extend " . Style::class);
        }

        /** @var Style $instance */
        $instance = app($style);
        $contexts = $instance->getContexts();

        foreach ($contexts as $context) {
            if ( ! isset($this->assets[$context])) {
                $this->assets[$context] = new AssetContext(
                    scripts: [],
                    styles: [],
                );
            }

            $this->assets[$context]->styles[] = $style;
        }
    }

    /**
     * Add multiple scripts to the registry.
     *
     * @unreleased
     *
     * @param string[] $styles Array of fully-qualified Style class names.
     */
    public function addStyles(array $styles): void
    {
        foreach ($styles as $style) {
            $this->addOneStyle($style);
        }
    }
}
