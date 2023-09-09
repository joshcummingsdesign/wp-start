<?php

declare(strict_types=1);

namespace WPStart\Blocks\Registrars;

use InvalidArgumentException;
use WP_Block_Parser;
use WPStart\Blocks\Contracts\Block;
use WPStart\Blocks\HelloWorld\Block as HelloWorldBlock;

use function WPStart\Framework\ServiceContainer\app;

/**
 * Gutenberg block registrar.
 *
 * @unreleased
 */
class Blocks
{
    /**
     * Blocks registry.
     *
     * @unreleased
     *
     * @var string[] Array of fully-qualified Block class names.
     */
    private array $blocks = [
        HelloWorldBlock::class,
    ];

    /**
     * Registered blocks.
     *
     * @var array<string, Block> [ Fully-qualified Block class name => Block ]
     */
    private array $registered = [];

    /**
     * Block parser.
     */
    private WP_Block_Parser $parser;

    /**
     * The post content.
     */
    private ?string $postContent;

    /**
     * Get contexts.
     *
     * @unreleased
     *
     * @return array<string, callable> [ $context => isContext(): bool ]
     */
    private function getContexts(): array
    {
        return [
            'global' => static fn() => true,
            'post-content' => [$this, 'isInPostContent'],
            'post' => static fn() => is_admin() || is_single(),
            'blog-archive' => static fn() => is_home() || is_archive(),
            'page' => static fn() => ! is_front_page() && is_page(),
            'search-results' => static fn() => is_search(),
            'home' => static fn() => is_front_page(),
        ];
    }

    /**
     * Get registered blocks.
     *
     * @unreleased
     *
     * @return array<string, Block> [ Fully-qualified Block class name => Block ]
     */
    public function getRegisteredBlocks(): array
    {
        return $this->registered;
    }

    /**
     * Get block parser.
     *
     * @unreleased
     */
    private function getParser(): WP_Block_Parser
    {
        if ( ! isset($this->parser)) {
            $this->parser = new WP_Block_Parser();
        }

        return $this->parser;
    }

    /**
     * Get post content.
     *
     * @unreleased
     */
    private function getPostContent(): ?string
    {
        if ( ! isset($this->postContent)) {
            $postContent = get_the_content();
            $this->postContent = ! empty($postContent) ? $postContent : null;
        }

        return $this->postContent;
    }

    /**
     * Whether a block is in the post content.
     *
     * @unreleased
     */
    private function isInPostContent(Block $block): bool
    {
        $postContent = $this->getPostContent();

        if ( ! $postContent) {
            return false;
        }

        $blockMeta = $block->getBlockMeta();
        $parser = $this->getParser();
        $parsedBlocks = $parser->parse($postContent);

        foreach ($parsedBlocks as $parsedBlock) {
            if ( ! empty($parsedBlock['blockName']) && $parsedBlock['blockName'] === $blockMeta->name) {
                return true;
            }

            if ( ! empty($parsedBlock['innerBlocks'])) {
                foreach ($parsedBlock['innerBlocks'] as $innerBlock) {
                    if ( ! empty($innerBlock['blockName']) && $innerBlock['blockName'] === $blockMeta->name) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    /**
     * Register blocks.
     *
     * @unreleased
     */
    public function register(): void
    {
        foreach ($this->blocks as $block) {
            if (isset($this->registered[$block])) {
                continue;
            }

            if ( ! is_subclass_of($block, Block::class)) {
                throw new InvalidArgumentException("$block must extend " . Block::class);
            }

            /** @var Block $instance */
            $instance = app($block);
            $instance->register();
            $this->registered[$block] = $instance;
        }
    }

    /**
     * Enqueue block editor scripts.
     *
     * @unreleased
     */
    public function enqueueEditorAssets(): void
    {
        // Never enqueue on frontend
        if ( ! is_admin()) {
            return;
        }

        foreach ($this->getRegisteredBlocks() as $name => $block) {
            $block->enqueueEditorAssets();
        }
    }

    /**
     * Enqueue block view scripts.
     *
     * @unreleased
     */
    public function enqueueAssets(): void
    {
        foreach ($this->getRegisteredBlocks() as $name => $block) {
            // Enqueue in admin
            if (is_admin()) {
                $block->enqueueAssets();
                continue;
            }

            $blockContexts = $block->getContexts();

            foreach ($this->getContexts() as $context => $isContext) {
                if (in_array($context, $blockContexts) && $isContext($block)) {
                    $block->enqueueAssets();
                    break;
                }
            }
        }
    }
}
