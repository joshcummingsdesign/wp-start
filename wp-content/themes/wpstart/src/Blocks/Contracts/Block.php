<?php

declare(strict_types=1);

namespace WPStart\Blocks\Contracts;

use ReflectionClass;
use WPStart\Blocks\Registrars\Blocks;
use WPStart\Framework\Assets\Facades\Assets\Assets;
use WPStart\Framework\ServerSideRenderer\Repositories\ServerSideRenderer;
use WPStart\Framework\ViewModels\Contracts\ViewModel;

use function WPStart\Framework\ServiceContainer\app;

/**
 * The block contract.
 *
 * @unreleased
 */
abstract class Block
{
    /**
     * The reference to the child class.
     *
     * @unreleased
     */
    private ReflectionClass $childRef;

    /**
     * The path to the block's directory.
     *
     * @unreleased
     */
    private string $directory;

    /**
     * The block.json data.
     *
     * @unreleased
     */
    private object $blockMeta;

    /**
     * The block name.
     *
     * @unreleased
     */
    private string $name;

    /**
     * The block's script slug.
     *
     * Camel-case version of the block's directory name.
     *
     * @unreleased
     */
    private string $scriptSlug;

    /**
     * The block's editor style handle.
     *
     * @unreleased
     */
    private string $editorStyleHandle;

    /**
     * The block's editor stylesheet name.
     *
     * @unreleased
     */
    private string $editorStylesheetName;

    /**
     * The block's editor stylesheet URI.
     *
     * @unreleased
     */
    private string $editorStylesheetUri;

    /**
     * The block's editor stylesheet path.
     *
     * @unreleased
     */
    private string $editorStylesheetPath;

    /**
     * The block's editor script handle.
     *
     * @unreleased
     */
    private string $editorScriptHandle;

    /**
     * The block's editor script name.
     *
     * @unreleased
     */
    private string $editorScriptName;

    /**
     * The block's editor script URI.
     *
     * @unreleased
     */
    private string $editorScriptUri;

    /**
     * The block's editor script path.
     *
     * @unreleased
     */
    private string $editorScriptPath;

    /**
     * The block's frontend style handle.
     *
     * @unreleased
     */
    private string $frontendStyleHandle;

    /**
     * The block's frontend stylesheet name.
     *
     * @unreleased
     */
    private string $frontendStylesheetName;

    /**
     * The block's frontend stylesheet URI.
     *
     * @unreleased
     */
    private string $frontendStylesheetUri;

    /**
     * The block's frontend stylesheet path.
     *
     * @unreleased
     */
    private string $frontendStylesheetPath;

    /**
     * The block's frontend script handle.
     *
     * @unreleased
     */
    private string $frontendScriptHandle;

    /**
     * The block's frontend script name.
     *
     * @unreleased
     */
    private string $frontendScriptName;

    /**
     * The block's frontend script URI.
     *
     * @unreleased
     */
    private string $frontendScriptUri;

    /**
     * The block's frontend script path.
     *
     * @unreleased
     */
    private string $frontendScriptPath;

    /**
     * The block's server script name.
     *
     * @unreleased
     */
    private string $serverScriptName;

    /**
     * The block's asset meta.
     *
     * @unreleased
     *
     * @var array<string, string|string[]> [ 'dependencies' => string[], 'version' => string ]
     */
    private array $assetMeta;

    /**
     * The block view model.
     *
     * @unreleased
     */
    private array $viewModel;

    /**
     * Get the reflection class.
     *
     * @unreleased
     */
    private function getChildRef(): ReflectionClass
    {
        if ( ! isset($this->childRef)) {
            $this->childRef = new ReflectionClass(get_class($this));
        }

        return $this->childRef;
    }

    /**
     * Get the block's directory.
     *
     * @unreleased
     */
    public function getDirectory(): string
    {
        if ( ! isset($this->directory)) {
            $childRef = $this->getChildRef();
            $this->directory = dirname($childRef->getFileName());
        }

        return $this->directory;
    }

    /**
     * Get the block.json data.
     *
     * @unreleased
     */
    public function getBlockMeta(): object
    {
        if ( ! isset($this->blockMeta)) {
            $this->blockMeta = json_decode(
                file_get_contents($this->getDirectory() . '/block.json'),
            );
        }

        return $this->blockMeta;
    }

    /**
     * Get the block contexts.
     *
     * @see Blocks::getContexts()
     *
     * @unreleased
     *
     * @return string[] Array of contexts.
     */
    public function getContexts(): array
    {
        return ['post-content'];
    }

    /**
     * Get the block name.
     *
     * @unreleased
     */
    public function getName(): string
    {
        if ( ! isset($this->name)) {
            $blockMeta = $this->getBlockMeta();
            $this->name = str_replace('/', '-', $blockMeta->name);
        }

        return $this->name;
    }

    /**
     * Get the block's script slug.
     *
     * Camel-case version of the block's directory name.
     *
     * @unreleased
     */
    public function getScriptSlug(): string
    {
        if ( ! isset($this->scriptSlug)) {
            $path = explode('/', $this->getDirectory());
            $this->scriptSlug = lcfirst(end($path));
        }

        return $this->scriptSlug;
    }

    /**
     * Get the block's editor style handle.
     *
     * @unreleased
     */
    public function getEditorStyleHandle(): string
    {
        if ( ! isset($this->editorStyleHandle)) {
            $this->editorStyleHandle = $this->getName() . '-editor-style';
        }

        return $this->editorStyleHandle;
    }

    /**
     * Get the block's editor stylesheet name.
     *
     * @unreleased
     */
    public function getEditorStylesheetName(): string
    {
        if ( ! isset($this->editorStylesheetName)) {
            $this->editorStylesheetName = $this->getScriptSlug() . 'BlockEditor.css';
        }

        return $this->editorStylesheetName;
    }

    /**
     * Get the block's editor stylesheet URI.
     *
     * @unreleased
     */
    public function getEditorStylesheetUri(): string
    {
        if ( ! isset($this->editorStylesheetUri)) {
            $this->editorStylesheetUri = Assets::getBuildDirectoryUri() . '/client/' . $this->getEditorStylesheetName();
        }

        return $this->editorStylesheetUri;
    }

    /**
     * Get the block editor style path.
     *
     * @unreleased
     */
    public function getEditorStylesheetPath(): string
    {
        if ( ! isset($this->editorStylesheetPath)) {
            $this->editorStylesheetPath = Assets::getBuildDirectoryPath() . '/client/' . $this->getEditorStylesheetName();
        }

        return $this->editorStylesheetPath;
    }

    /**
     * Get the block's editor script handle.
     *
     * @unreleased
     */
    public function getEditorScriptHandle(): string
    {
        if ( ! isset($this->editorScriptHandle)) {
            $this->editorScriptHandle = $this->getName() . '-editor-script';
        }

        return $this->editorScriptHandle;
    }

    /**
     * Get the block's editor script name.
     *
     * @unreleased
     */
    public function getEditorScriptName(): string
    {
        if ( ! isset($this->editorScriptName)) {
            $this->editorScriptName = $this->getScriptSlug() . 'BlockEditor.js';
        }

        return $this->editorScriptName;
    }

    /**
     * Get the block's editor script URI.
     *
     * @unreleased
     */
    public function getEditorScriptUri(): string
    {
        if ( ! isset($this->editorScriptUri)) {
            $this->editorScriptUri = Assets::getBuildDirectoryUri() . '/client/' . $this->getEditorScriptName();
        }

        return $this->editorScriptUri;
    }

    /**
     * Get the block editor script path.
     *
     * @unreleased
     */
    public function getEditorScriptPath(): string
    {
        if ( ! isset($this->editorScriptPath)) {
            $this->editorScriptPath = Assets::getBuildDirectoryPath() . '/client/' . $this->getEditorScriptName();
        }

        return $this->editorScriptPath;
    }

    /**
     * Get the block's frontend style handle.
     *
     * @unreleased
     */
    public function getFrontendStyleHandle(): string
    {
        if ( ! isset($this->frontendStyleHandle)) {
            $this->frontendStyleHandle = $this->getName() . '-frontend-style';
        }

        return $this->frontendStyleHandle;
    }

    /**
     * Get the block's frontend stylesheet name.
     *
     * @unreleased
     */
    public function getFrontendStylesheetName(): string
    {
        if ( ! isset($this->frontendStylesheetName)) {
            $this->frontendStylesheetName = $this->getScriptSlug() . 'BlockFrontend.css';
        }

        return $this->frontendStylesheetName;
    }

    /**
     * Get the block's frontend stylesheet URI.
     *
     * @unreleased
     */
    public function getFrontendStylesheetUri(): string
    {
        if ( ! isset($this->frontendStylesheetUri)) {
            $this->frontendStylesheetUri = Assets::getBuildDirectoryUri() . '/client/' . $this->getFrontendStylesheetName();
        }

        return $this->frontendStylesheetUri;
    }

    /**
     * Get the block's stylesheet path.
     *
     * @unreleased
     */
    public function getFrontendStylesheetPath(): string
    {
        if ( ! isset($this->frontendStylesheetPath)) {
            $this->frontendStylesheetPath = Assets::getBuildDirectoryPath() . '/client/' . $this->getFrontendStylesheetName();
        }

        return $this->frontendStylesheetPath;
    }

    /**
     * Get the block's frontend script handle.
     *
     * @unreleased
     */
    public function getFrontendScriptHandle(): string
    {
        if ( ! isset($this->frontendScriptHandle)) {
            $this->frontendScriptHandle = $this->getName() . '-frontend-script';
        }

        return $this->frontendScriptHandle;
    }

    /**
     * Get the block's frontend script name.
     *
     * @unreleased
     */
    public function getFrontendScriptName(): string
    {
        if ( ! isset($this->frontendScriptName)) {
            $this->frontendScriptName = $this->getScriptSlug() . 'BlockFrontend.js';
        }

        return $this->frontendScriptName;
    }

    /**
     * Get the block's frontend script URI.
     *
     * @unreleased
     */
    public function getFrontendScriptUri(): string
    {
        if ( ! isset($this->frontendScriptUri)) {
            $this->frontendScriptUri = Assets::getBuildDirectoryUri() . '/client/' . $this->getFrontendScriptName();
        }

        return $this->frontendScriptUri;
    }

    /**
     * Get the block's frontend script path.
     *
     * @unreleased
     */
    public function getFrontendScriptPath(): string
    {
        if ( ! isset($this->frontendScriptPath)) {
            $this->frontendScriptPath = Assets::getBuildDirectoryPath() . '/client/' . $this->getFrontendScriptName();
        }

        return $this->frontendScriptPath;
    }

    /**
     * Get the block's server script name.
     *
     * @unreleased
     */
    public function getServerScriptName(): string
    {
        if ( ! isset($this->serverScriptName)) {
            $this->serverScriptName = $this->getScriptSlug() . 'BlockServer.js';
        }

        return $this->serverScriptName;
    }

    /**
     * Get the block asset meta.
     *
     * @unreleased
     *
     * @return array<string, string|string[]> [ 'dependencies' => string[], 'version' => string ]
     */
    public function getAssetMeta(): array
    {
        if ( ! isset($this->assetMeta)) {
            $this->assetMeta = require Assets::getAssetMetaPath($this->getFrontendScriptPath());
        }

        return $this->assetMeta;
    }

    /**
     * Enqueue the block's editor scripts and styles.
     *
     * @unreleased
     */
    public function enqueueEditorAssets(): void
    {
        $assetMeta = $this->getAssetMeta();

        wp_register_script(
            $this->getEditorScriptHandle(),
            $this->getEditorScriptUri(),
            $assetMeta['dependencies'],
            $assetMeta['version'],
            true
        );

        wp_localize_script(
            $this->getEditorScriptHandle(),
            'app',
            $this->getLocalizationData()
        );

        wp_enqueue_script($this->getEditorScriptHandle());

        if (file_exists($this->getEditorStylesheetPath())) {
            wp_enqueue_style(
                $this->getEditorStyleHandle(),
                $this->getEditorStylesheetUri(),
                [],
                $assetMeta['version']
            );
        }
    }

    /**
     * Enqueue the block's frontend scripts and styles.
     *
     * @unreleased
     */
    public function enqueueAssets(): void
    {
        $assetMeta = $this->getAssetMeta();

        wp_register_script(
            $this->getFrontendScriptHandle(),
            $this->getFrontendScriptUri(),
            $assetMeta['dependencies'],
            $assetMeta['version'],
            true
        );

        wp_localize_script(
            $this->getFrontendScriptHandle(),
            'app',
            $this->getLocalizationData()
        );

        wp_enqueue_script($this->getFrontendScriptHandle());

        if (file_exists($this->getFrontendStylesheetPath())) {
            wp_enqueue_style(
                $this->getFrontendStyleHandle(),
                $this->getFrontendStylesheetUri(),
                [],
                $assetMeta['version']
            );
        }
    }

    /**
     * Register the block.
     *
     * @unreleased
     */
    public function register(): void
    {
        register_block_type(
            $this->getDirectory(),
            [
                'render_callback' => [$this, 'render'],
            ]
        );
    }

    /**
     * Get the data to pass to the block's scripts via `wp_localize_script`.
     *
     * Injects the data into `window.app`.
     *
     * @unreleased
     */
    public function getLocalizationData(): array
    {
        return [
            'root' => $this->getName(),
            'data' => $this->getViewModel(),
        ];
    }

    /**
     * Set the block's view model.
     *
     * Injects the data into `window.app.data`.
     *
     * @unreleased
     *
     * @return ?string The fully-qualified ViewModel class name.
     */
    public function setViewModel(): ?string
    {
        return null;
    }

    /**
     * Get the block's view model.
     *
     * @see Block::setViewModel()
     *
     * @unreleased
     */
    public function getViewModel(): array
    {
        $viewModelName = $this->setViewModel();

        if ( ! isset($this->viewModel) && $viewModelName) {
            /** @var ViewModel $viewModel */
            $viewModel = app($viewModelName);
            $this->viewModel = (array)$viewModel::build();
        }

        return $this->viewModel ?? [];
    }

    /**
     * Server-side render the block.
     *
     * @unreleased
     */
    public function serverSideRender(array $attributes): string
    {
        /** @var ServerSideRenderer $ssr */
        $ssr = app(ServerSideRenderer::class);

        return $ssr->render(
            $this->getServerScriptName(),
            array_merge($attributes, $this->getViewModel())
        );
    }

    /**
     * Render the block.
     *
     * Injects the attributes into `window[blockId]`.
     *
     * @unreleased
     */
    public function render(array $attributes, string $content): string
    {
        $blockId = str_replace('-', '_', $attributes['blockId']);
        $root = $this->getName();
        $view = $this->serverSideRender($attributes);

        ob_start(); ?>

        <script>
            window["<?= $blockId ?>"] = <?= json_encode($attributes) ?>;
        </script>

        <div id="<?= $attributes['blockId'] ?>" class="<?= $root ?>">
            <?= $view ?>
        </div>

        <?php
        return ob_get_clean();
    }
}
