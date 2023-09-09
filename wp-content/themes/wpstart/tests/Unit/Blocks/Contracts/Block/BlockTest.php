<?php

declare(strict_types=1);

namespace Tests\Unit\Blocks\Contracts\Block;

use PHPUnit\Framework\MockObject\MockBuilder;
use Tests\TestCase;
use Tests\Unit\Blocks\Stubs\Block1;
use Tests\Unit\Blocks\Stubs\ViewModel;
use WPStart\Blocks\Contracts\Block;
use WPStart\Framework\Assets\Facades\Assets\AssetsFacade;
use WPStart\Framework\ServerSideRenderer\Repositories\ServerSideRenderer;

/**
 * Test the block contract.
 */
final class BlockTest extends TestCase
{
    private string $stubsDir;
    private string $testBlockDir;

    protected function setUp(): void
    {
        parent::setUp();

        $this->stubsDir = __DIR__ . '/../../Stubs';
        $this->testBlockDir = $this->stubsDir . '/TestBlock';
    }

    private function trimHtml(string $html): string
    {
        $html = preg_replace('~>\s+<~', '><', trim($html));
        $html = preg_replace('~>\s+window~', '>window', $html);
        $html = preg_replace('~;\s+<~', ';<', $html);
        $html = implode("\n", array_map('trim', explode("\n", $html)));

        return $html . "\n";
    }

    public function testShouldGetBlockMeta(): void
    {
        $block = $this->createMock(
            Block::class,
            function (MockBuilder $builder) {
                $mock = $builder->onlyMethods(['getDirectory'])->getMock();

                $mock->expects($this->once())
                    ->method('getDirectory')
                    ->with()
                    ->willReturn($this->testBlockDir);

                return $mock;
            }
        );

        $block->getBlockMeta(); // Call it twice to test caching
        $blockMeta = $block->getBlockMeta();

        self::assertSame('wpstart/test-block', $blockMeta->name);
    }

    public function testShouldGetContexts(): void
    {
        $block = new Block1();
        self::assertSame(['post-content'], $block->getContexts());
    }

    public function testShouldGetName(): void
    {
        $block = $this->createMock(
            Block::class,
            function (MockBuilder $builder) {
                $mock = $builder->onlyMethods(['getBlockMeta'])->getMock();

                $mock->expects($this->once())
                    ->method('getBlockMeta')
                    ->with()
                    ->willReturn((object)['name' => 'wpstart/test-block']);

                return $mock;
            }
        );

        $block->getName(); // Call it twice to test caching
        $actual = $block->getName();

        self::assertSame('wpstart-test-block', $actual);
    }

    public function testShouldGetScriptSlug(): void
    {
        $block = $this->createMock(
            Block::class,
            function (MockBuilder $builder) {
                $mock = $builder->onlyMethods(['getDirectory'])->getMock();

                $mock->expects($this->once())
                    ->method('getDirectory')
                    ->with()
                    ->willReturn($this->testBlockDir);

                return $mock;
            }
        );

        $block->getScriptSlug(); // Call it twice to test caching
        $actual = $block->getScriptSlug();

        self::assertSame('testBlock', $actual);
    }

    public function testShouldGetEditorStyleHandle(): void
    {
        $block = $this->createMock(
            Block::class,
            function (MockBuilder $builder) {
                $mock = $builder->onlyMethods(['getName'])->getMock();

                $mock->expects($this->once())
                    ->method('getName')
                    ->with()
                    ->willReturn('wpstart-test-block');

                return $mock;
            }
        );

        $block->getEditorStyleHandle(); // Call it twice to test caching
        $actual = $block->getEditorStyleHandle();

        self::assertSame('wpstart-test-block-editor-style', $actual);
    }

    public function testShouldGetEditorStylesheetName(): void
    {
        $block = $this->createMock(
            Block::class,
            function (MockBuilder $builder) {
                $mock = $builder->onlyMethods(['getScriptSlug'])->getMock();

                $mock->expects($this->once())
                    ->method('getScriptSlug')
                    ->with()
                    ->willReturn('testBlock');

                return $mock;
            }
        );

        $block->getEditorStylesheetName(); // Call it twice to test caching
        $actual = $block->getEditorStylesheetName();

        self::assertSame('testBlockBlockEditor.css', $actual);
    }

    public function testShouldGetEditorStylesheetUri(): void
    {
        $this->mock(AssetsFacade::class, function (MockBuilder $builder) {
            $mock = $builder->onlyMethods(['getBuildDirectoryUri'])->getMock();

            $mock->expects($this->once())
                ->method('getBuildDirectoryUri')
                ->with()
                ->willReturn('https://example.com/build');

            return $mock;
        });

        $block = $this->createMock(
            Block::class,
            function (MockBuilder $builder) {
                $mock = $builder->onlyMethods(['getEditorStylesheetName'])->getMock();

                $mock->expects($this->once())
                    ->method('getEditorStylesheetName')
                    ->with()
                    ->willReturn('testBlockBlockEditor.css');

                return $mock;
            }
        );

        $block->getEditorStylesheetUri(); // Call it twice to test caching
        $actual = $block->getEditorStylesheetUri();

        self::assertSame('https://example.com/build/client/testBlockBlockEditor.css', $actual);
    }

    public function testShouldGetEditorStylesheetPath(): void
    {
        $this->mock(AssetsFacade::class, function (MockBuilder $builder) {
            $mock = $builder->onlyMethods(['getBuildDirectoryPath'])->getMock();

            $mock->expects($this->once())
                ->method('getBuildDirectoryPath')
                ->with()
                ->willReturn('/var/www/build');

            return $mock;
        });

        $block = $this->createMock(
            Block::class,
            function (MockBuilder $builder) {
                $mock = $builder->onlyMethods(['getEditorStylesheetName'])->getMock();

                $mock->expects($this->once())
                    ->method('getEditorStylesheetName')
                    ->with()
                    ->willReturn('testBlockBlockEditor.css');

                return $mock;
            }
        );

        $block->getEditorStylesheetPath(); // Call it twice to test caching
        $actual = $block->getEditorStylesheetPath();

        self::assertSame('/var/www/build/client/testBlockBlockEditor.css', $actual);
    }

    public function testShouldGetEditorScriptHandle(): void
    {
        $block = $this->createMock(
            Block::class,
            function (MockBuilder $builder) {
                $mock = $builder->onlyMethods(['getName'])->getMock();

                $mock->expects($this->once())
                    ->method('getName')
                    ->with()
                    ->willReturn('wpstart-test-block');

                return $mock;
            }
        );

        $block->getEditorScriptHandle(); // Call it twice to test caching
        $actual = $block->getEditorScriptHandle();

        self::assertSame('wpstart-test-block-editor-script', $actual);
    }

    public function testShouldGetEditorScriptName(): void
    {
        $block = $this->createMock(
            Block::class,
            function (MockBuilder $builder) {
                $mock = $builder->onlyMethods(['getScriptSlug'])->getMock();

                $mock->expects($this->once())
                    ->method('getScriptSlug')
                    ->with()
                    ->willReturn('testBlock');

                return $mock;
            }
        );

        $block->getEditorScriptName(); // Call it twice to test caching
        $actual = $block->getEditorScriptName();

        self::assertSame('testBlockBlockEditor.js', $actual);
    }

    public function testShouldGetEditorScriptUri(): void
    {
        $this->mock(AssetsFacade::class, function (MockBuilder $builder) {
            $mock = $builder->onlyMethods(['getBuildDirectoryUri'])->getMock();

            $mock->expects($this->once())
                ->method('getBuildDirectoryUri')
                ->with()
                ->willReturn('https://example.com/build');

            return $mock;
        });

        $block = $this->createMock(
            Block::class,
            function (MockBuilder $builder) {
                $mock = $builder->onlyMethods(['getEditorScriptName'])->getMock();

                $mock->expects($this->once())
                    ->method('getEditorScriptName')
                    ->with()
                    ->willReturn('testBlockBlockEditor.js');

                return $mock;
            }
        );

        $block->getEditorScriptUri(); // Call it twice to test caching
        $actual = $block->getEditorScriptUri();

        self::assertSame('https://example.com/build/client/testBlockBlockEditor.js', $actual);
    }

    public function testShouldGetEditorScriptPath(): void
    {
        $this->mock(AssetsFacade::class, function (MockBuilder $builder) {
            $mock = $builder->onlyMethods(['getBuildDirectoryPath'])->getMock();

            $mock->expects($this->once())
                ->method('getBuildDirectoryPath')
                ->with()
                ->willReturn('/var/www/build');

            return $mock;
        });

        $block = $this->createMock(
            Block::class,
            function (MockBuilder $builder) {
                $mock = $builder->onlyMethods(['getEditorScriptName'])->getMock();

                $mock->expects($this->once())
                    ->method('getEditorScriptName')
                    ->with()
                    ->willReturn('testBlockBlockEditor.js');

                return $mock;
            }
        );

        $block->getEditorScriptPath(); // Call it twice to test caching
        $actual = $block->getEditorScriptPath();

        self::assertSame('/var/www/build/client/testBlockBlockEditor.js', $actual);
    }

    public function testShouldGetFrontendStyleHandle(): void
    {
        $block = $this->createMock(
            Block::class,
            function (MockBuilder $builder) {
                $mock = $builder->onlyMethods(['getName'])->getMock();

                $mock->expects($this->once())
                    ->method('getName')
                    ->with()
                    ->willReturn('wpstart-test-block');

                return $mock;
            }
        );

        $block->getFrontendStyleHandle(); // Call it twice to test caching
        $actual = $block->getFrontendStyleHandle();

        self::assertSame('wpstart-test-block-frontend-style', $actual);
    }

    public function testShouldGetFrontendStylesheetName(): void
    {
        $block = $this->createMock(
            Block::class,
            function (MockBuilder $builder) {
                $mock = $builder->onlyMethods(['getScriptSlug'])->getMock();

                $mock->expects($this->once())
                    ->method('getScriptSlug')
                    ->with()
                    ->willReturn('testBlock');

                return $mock;
            }
        );

        $block->getFrontendStylesheetName(); // Call it twice to test caching
        $actual = $block->getFrontendStylesheetName();

        self::assertSame('testBlockBlockFrontend.css', $actual);
    }

    public function testShouldGetFrontendStylesheetUri(): void
    {
        $this->mock(AssetsFacade::class, function (MockBuilder $builder) {
            $mock = $builder->onlyMethods(['getBuildDirectoryUri'])->getMock();

            $mock->expects($this->once())
                ->method('getBuildDirectoryUri')
                ->with()
                ->willReturn('https://example.com/build');

            return $mock;
        });

        $block = $this->createMock(
            Block::class,
            function (MockBuilder $builder) {
                $mock = $builder->onlyMethods(['getFrontendStylesheetName'])->getMock();

                $mock->expects($this->once())
                    ->method('getFrontendStylesheetName')
                    ->with()
                    ->willReturn('testBlockBlockFrontend.css');

                return $mock;
            }
        );

        $block->getFrontendStylesheetUri(); // Call it twice to test caching
        $actual = $block->getFrontendStylesheetUri();

        self::assertSame('https://example.com/build/client/testBlockBlockFrontend.css', $actual);
    }

    public function testShouldGetFrontendStylesheetPath(): void
    {
        $this->mock(AssetsFacade::class, function (MockBuilder $builder) {
            $mock = $builder->onlyMethods(['getBuildDirectoryPath'])->getMock();

            $mock->expects($this->once())
                ->method('getBuildDirectoryPath')
                ->with()
                ->willReturn('/var/www/build');

            return $mock;
        });

        $block = $this->createMock(
            Block::class,
            function (MockBuilder $builder) {
                $mock = $builder->onlyMethods(['getFrontendStylesheetName'])->getMock();

                $mock->expects($this->once())
                    ->method('getFrontendStylesheetName')
                    ->with()
                    ->willReturn('testBlockBlockFrontend.css');

                return $mock;
            }
        );

        $block->getFrontendStylesheetPath(); // Call it twice to test caching
        $actual = $block->getFrontendStylesheetPath();

        self::assertSame('/var/www/build/client/testBlockBlockFrontend.css', $actual);
    }

    public function testShouldGetFrontendScriptHandle(): void
    {
        $block = $this->createMock(
            Block::class,
            function (MockBuilder $builder) {
                $mock = $builder->onlyMethods(['getName'])->getMock();

                $mock->expects($this->once())
                    ->method('getName')
                    ->with()
                    ->willReturn('wpstart-test-block');

                return $mock;
            }
        );

        $block->getFrontendScriptHandle(); // Call it twice to test caching
        $actual = $block->getFrontendScriptHandle();

        self::assertSame('wpstart-test-block-frontend-script', $actual);
    }

    public function testShouldGetFrontendScriptName(): void
    {
        $block = $this->createMock(
            Block::class,
            function (MockBuilder $builder) {
                $mock = $builder->onlyMethods(['getScriptSlug'])->getMock();

                $mock->expects($this->once())
                    ->method('getScriptSlug')
                    ->with()
                    ->willReturn('testBlock');

                return $mock;
            }
        );

        $block->getFrontendScriptName(); // Call it twice to test caching
        $actual = $block->getFrontendScriptName();

        self::assertSame('testBlockBlockFrontend.js', $actual);
    }

    public function testShouldGetFrontendScriptUri(): void
    {
        $this->mock(AssetsFacade::class, function (MockBuilder $builder) {
            $mock = $builder->onlyMethods(['getBuildDirectoryUri'])->getMock();

            $mock->expects($this->once())
                ->method('getBuildDirectoryUri')
                ->with()
                ->willReturn('https://example.com/build');

            return $mock;
        });

        $block = $this->createMock(
            Block::class,
            function (MockBuilder $builder) {
                $mock = $builder->onlyMethods(['getFrontendScriptName'])->getMock();

                $mock->expects($this->once())
                    ->method('getFrontendScriptName')
                    ->with()
                    ->willReturn('testBlockBlockFrontend.js');

                return $mock;
            }
        );

        $block->getFrontendScriptUri(); // Call it twice to test caching
        $actual = $block->getFrontendScriptUri();

        self::assertSame('https://example.com/build/client/testBlockBlockFrontend.js', $actual);
    }

    public function testShouldGetFrontendScriptPath(): void
    {
        $this->mock(AssetsFacade::class, function (MockBuilder $builder) {
            $mock = $builder->onlyMethods(['getBuildDirectoryPath'])->getMock();

            $mock->expects($this->once())
                ->method('getBuildDirectoryPath')
                ->with()
                ->willReturn('/var/www/build');

            return $mock;
        });

        $block = $this->createMock(
            Block::class,
            function (MockBuilder $builder) {
                $mock = $builder->onlyMethods(['getFrontendScriptName'])->getMock();

                $mock->expects($this->once())
                    ->method('getFrontendScriptName')
                    ->with()
                    ->willReturn('testBlockBlockFrontend.js');

                return $mock;
            }
        );

        $block->getFrontendScriptPath(); // Call it twice to test caching
        $actual = $block->getFrontendScriptPath();

        self::assertSame('/var/www/build/client/testBlockBlockFrontend.js', $actual);
    }

    public function testShouldGetServerScriptName(): void
    {
        $block = $this->createMock(
            Block::class,
            function (MockBuilder $builder) {
                $mock = $builder->onlyMethods(['getScriptSlug'])->getMock();

                $mock->expects($this->once())
                    ->method('getScriptSlug')
                    ->with()
                    ->willReturn('testBlock');

                return $mock;
            }
        );

        $block->getServerScriptName(); // Call it twice to test caching
        $actual = $block->getServerScriptName();

        self::assertSame('testBlockBlockServer.js', $actual);
    }

    public function testShouldGetAssetMeta(): void
    {
        $this->mock(AssetsFacade::class, function (MockBuilder $builder) {
            $mock = $builder->onlyMethods(['getAssetMetaPath'])->getMock();

            $mock->expects($this->once())
                ->method('getAssetMetaPath')
                ->with()
                ->willReturn($this->stubsDir . '/build/testBlockBlockFrontend.asset.php');

            return $mock;
        });

        $block = $this->createMock(
            Block::class,
            function (MockBuilder $builder) {
                $mock = $builder->onlyMethods(['getFrontendScriptPath'])->getMock();

                $mock->expects($this->once())
                    ->method('getFrontendScriptPath')
                    ->with()
                    ->willReturn('/var/www/build/testBlockBlockFrontend.js');

                return $mock;
            }
        );

        $block->getAssetMeta(); // Call it twice to test caching
        $assetMeta = $block->getAssetMeta();

        self::assertSame(['react'], $assetMeta['dependencies']);
        self::assertSame('abcd1234', $assetMeta['version']);
    }

    public function testShouldGetLocalizationData(): void
    {
        $viewModel = [
            'heading' => 'Hello World',
            'text' => 'Lorem ipsum...',
        ];

        $block = $this->createMock(
            Block::class,
            function (MockBuilder $builder) use ($viewModel) {
                $mock = $builder->onlyMethods(['getName', 'getViewModel'])->getMock();

                $mock->expects($this->once())
                    ->method('getName')
                    ->with()
                    ->willReturn('wpstart-test-block');

                $mock->expects($this->once())
                    ->method('getViewModel')
                    ->with()
                    ->willReturn($viewModel);

                return $mock;
            }
        );

        $expected = [
            'root' => 'wpstart-test-block',
            'data' => $viewModel,
        ];

        self::assertSame($expected, $block->getLocalizationData());
    }

    public function testShouldSetViewModel(): void
    {
        $block = new Block1();
        self::assertNull($block->setViewModel());
    }

    public function testShouldGetEmptyViewModel(): void
    {
        $block = $this->createMock(
            Block::class,
            function (MockBuilder $builder) {
                $mock = $builder->onlyMethods(['setViewModel'])->getMock();

                $mock->expects($this->once())
                    ->method('setViewModel')
                    ->with()
                    ->willReturn(null);

                return $mock;
            }
        );

        self::assertSame([], $block->getViewModel());
    }

    public function testShouldGetViewModel(): void
    {
        $block = $this->createMock(
            Block::class,
            function (MockBuilder $builder) {
                $mock = $builder->onlyMethods(['setViewModel'])->getMock();

                $mock->expects($this->exactly(2))
                    ->method('setViewModel')
                    ->with()
                    ->willReturn(ViewModel::class);

                return $mock;
            }
        );

        $block->getViewModel(); // Call it twice to test caching
        $viewModel = $block->getViewModel();

        self::assertSame(0, $viewModel['numCalled']);
    }

    public function testShouldServerSideRender(): void
    {
        $attributes = [
            'blockId' => 'abc123',
            'className' => 'my-custom-class',
        ];

        $viewModel = [
            'heading' => 'Hello World',
            'text' => 'Lorem ipsum...',
        ];

        $data = array_merge($attributes, $viewModel);

        $this->mock(
            ServerSideRenderer::class,
            function (MockBuilder $builder) use ($data) {
                $mock = $builder->onlyMethods(['render'])->getMock();

                $mock->expects($this->once())
                    ->method('render')
                    ->with('testBlockBlockServer.js', $data)
                    ->willReturn('<div>Hello World</div>');

                return $mock;
            }
        );

        $block = $this->createMock(
            Block::class,
            function (MockBuilder $builder) use ($viewModel) {
                $mock = $builder->onlyMethods(['getServerScriptName', 'getViewModel'])->getMock();

                $mock->expects($this->once())
                    ->method('getServerScriptName')
                    ->with()
                    ->willReturn('testBlockBlockServer.js');

                $mock->expects($this->once())
                    ->method('getViewModel')
                    ->with()
                    ->willReturn($viewModel);

                return $mock;
            }
        );

        $actual = $block->serverSideRender($attributes);

        self::assertSame('<div>Hello World</div>', $actual);
    }

    public function testShouldRender(): void
    {
        $content = '<div>Hello World</div>';

        $attributes = [
            'blockId' => 'abcd-12345',
            'className' => 'my-custom-class',
        ];

        $block = $this->createMock(
            Block::class,
            function (MockBuilder $builder) use ($attributes, $content) {
                $mock = $builder->onlyMethods(['getName', 'serverSideRender'])->getMock();

                $mock->expects($this->once())
                    ->method('getName')
                    ->with()
                    ->willReturn('wpstart-test-block');

                $mock->expects($this->once())
                    ->method('serverSideRender')
                    ->with($attributes)
                    ->willReturn($content);

                return $mock;
            }
        );

        $expected = file_get_contents($this->testBlockDir . '/render-output.txt');

        $actual = $block->render($attributes, $content);

        self::assertSame($this->trimHtml($expected), $this->trimHtml($actual));
    }
}
