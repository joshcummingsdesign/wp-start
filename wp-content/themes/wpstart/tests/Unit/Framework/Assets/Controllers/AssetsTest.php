<?php

declare(strict_types=1);

namespace Tests\Unit\Framework\Assets\Controllers;

use PHPUnit\Framework\MockObject\MockBuilder;
use Tests\TestCase;
use Tests\Unit\Framework\Assets\Stubs\AdminStyle;
use Tests\Unit\Framework\Assets\Stubs\GlobalScript;
use Tests\Unit\Framework\Assets\Stubs\GlobalStyle;
use Tests\Unit\Framework\Assets\Stubs\PostScript;
use Tests\Unit\Framework\Assets\Stubs\PostStyle;
use WPStart\Framework\Assets\Controllers\Assets;
use WPStart\Framework\Assets\DataTransferObjects\AssetContext;
use WPStart\Framework\Assets\Registrars\Assets as AssetsRegistrar;
use WPStart\Framework\Assets\Runtime;

/**
 * Test the assets controller.
 */
final class AssetsTest extends TestCase
{
    public function testShouldEnqueueScripts(): void
    {
        $contexts = [
            'global' => static fn() => true,
            'posts' => static fn() => false,
        ];

        $registrar = $this->createMock(
            AssetsRegistrar::class,
            function (MockBuilder $builder) {
                $mock = $builder
                    ->onlyMethods(['get'])
                    ->getMock();

                $mock->expects($this->once())
                    ->method('get')
                    ->with()
                    ->willReturn([
                        'global' => new AssetContext(
                            scripts: [GlobalScript::class],
                            styles: [],
                        ),
                        'posts' => new AssetContext(
                            scripts: [PostScript::class],
                            styles: [],
                        ),
                    ]);

                return $mock;
            }
        );

        $controller = $this->createMock(
            Assets::class,
            function (MockBuilder $builder) use ($contexts, $registrar) {
                $mock = $builder
                    ->onlyMethods([
                        'getContexts',
                        'getRegistrar',
                        'maybeEnqueue',
                    ])
                    ->getMock();

                $mock->expects($this->once())
                    ->method('getContexts')
                    ->with()
                    ->willReturn($contexts);

                $mock->expects($this->once())
                    ->method('getRegistrar')
                    ->with()
                    ->willReturn($registrar);

                $mock->expects($this->once())
                    ->method('maybeEnqueue')
                    ->with(GlobalScript::class);

                return $mock;
            }
        );

        $controller->enqueueScripts();
    }

    public function testShouldEnqueueStyles(): void
    {
        $contexts = [
            'global' => static fn() => true,
            'posts' => static fn() => false,
        ];

        $registrar = $this->createMock(
            AssetsRegistrar::class,
            function (MockBuilder $builder) {
                $mock = $builder
                    ->onlyMethods(['get'])
                    ->getMock();

                $mock->expects($this->once())
                    ->method('get')
                    ->with()
                    ->willReturn([
                        'global' => new AssetContext(
                            scripts: [],
                            styles: [GlobalStyle::class],
                        ),
                        'posts' => new AssetContext(
                            scripts: [],
                            styles: [PostStyle::class],
                        ),
                    ]);

                return $mock;
            }
        );

        $controller = $this->createMock(
            Assets::class,
            function (MockBuilder $builder) use ($contexts, $registrar) {
                $mock = $builder
                    ->onlyMethods([
                        'getContexts',
                        'getRegistrar',
                        'maybeEnqueue',
                    ])
                    ->getMock();

                $mock->expects($this->once())
                    ->method('getContexts')
                    ->with()
                    ->willReturn($contexts);

                $mock->expects($this->once())
                    ->method('getRegistrar')
                    ->with()
                    ->willReturn($registrar);

                $mock->expects($this->once())
                    ->method('maybeEnqueue')
                    ->with(GlobalStyle::class);

                return $mock;
            }
        );

        $controller->enqueueStyles();
    }

    public function testShouldAdminEnqueueScripts(): void
    {
        $registrar = $this->createMock(
            AssetsRegistrar::class,
            function (MockBuilder $builder) {
                $mock = $builder
                    ->onlyMethods(['get'])
                    ->getMock();

                $mock->expects($this->once())
                    ->method('get')
                    ->with()
                    ->willReturn([
                        'admin' => new AssetContext(
                            scripts: [Runtime::class],
                            styles: [],
                        ),
                        'hot' => new AssetContext(
                            scripts: [Runtime::class],
                            styles: [],
                        ),
                    ]);

                return $mock;
            }
        );

        $controller = $this->createMock(
            Assets::class,
            function (MockBuilder $builder) use ($registrar) {
                $mock = $builder
                    ->onlyMethods([
                        'getRegistrar',
                        'maybeAdminEnqueue',
                    ])
                    ->getMock();

                $mock->expects($this->once())
                    ->method('getRegistrar')
                    ->with()
                    ->willReturn($registrar);

                $mock->expects($this->once())
                    ->method('maybeAdminEnqueue')
                    ->with(Runtime::class);

                return $mock;
            }
        );

        $controller->adminEnqueueScripts();
    }

    public function testShouldAdminEnqueueStyles(): void
    {
        $registrar = $this->createMock(
            AssetsRegistrar::class,
            function (MockBuilder $builder) {
                $mock = $builder
                    ->onlyMethods(['get'])
                    ->getMock();

                $mock->expects($this->once())
                    ->method('get')
                    ->with()
                    ->willReturn([
                        'admin' => new AssetContext(
                            scripts: [],
                            styles: [AdminStyle::class],
                        ),
                    ]);

                return $mock;
            }
        );

        $controller = $this->createMock(
            Assets::class,
            function (MockBuilder $builder) use ($registrar) {
                $mock = $builder
                    ->onlyMethods([
                        'getRegistrar',
                        'maybeAdminEnqueue',
                    ])
                    ->getMock();

                $mock->expects($this->once())
                    ->method('getRegistrar')
                    ->with()
                    ->willReturn($registrar);

                $mock->expects($this->once())
                    ->method('maybeAdminEnqueue')
                    ->with(AdminStyle::class);

                return $mock;
            }
        );

        $controller->adminEnqueueStyles();
    }
}
