<?php

declare(strict_types=1);

namespace Tests\Unit\Framework\ServerSideRenderer\Repositories;

use Exception;
use PHPUnit\Framework\MockObject\MockBuilder;
use WPStart\Framework\Assets\Facades\Assets\AssetsFacade;
use WPStart\Framework\Log\Facades\LogFacade;
use WPStart\Framework\ServerSideRenderer\Repositories\ServerSideRenderer;
use Spatie\Ssr\Renderer;
use Tests\TestCase;

/**
 * Test the server-side renderer repository.
 */
final class ServerSideRendererTest extends TestCase
{

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
            AssetsFacade::class,
            function (MockBuilder $builder) {
                $mock = $builder->onlyMethods(['getBuildDirectoryPath'])->getMock();

                $mock->expects($this->once())
                    ->method('getBuildDirectoryPath')
                    ->with()
                    ->willReturn('/var/www/build');

                return $mock;
            }
        );

        $renderer = $this->createMock(
            Renderer::class,
            function (MockBuilder $builder) use ($data) {
                $mock = $builder->onlyMethods(['entry', 'context', 'render'])->getMock();

                $mock->expects($this->once())
                    ->method('entry')
                    ->with('/var/www/build/server/testBlockBlockServer.js')
                    ->willReturn($mock);

                $mock->expects($this->once())
                    ->method('context')
                    ->with($data)
                    ->willReturn($mock);

                $mock->expects($this->once())
                    ->method('render')
                    ->with()
                    ->willReturn('<div>Hello World</div>');

                return $mock;
            }
        );

        $ssr = $this->createMock(
            ServerSideRenderer::class,
            function (MockBuilder $builder) use ($renderer) {
                $mock = $builder->onlyMethods(['getRenderer'])->getMock();

                $mock->expects($this->once())
                    ->method('getRenderer')
                    ->with()
                    ->willReturn($renderer);

                return $mock;
            }
        );

        $actual = $ssr->render('testBlockBlockServer.js', $data);

        self::assertSame('<div>Hello World</div>', $actual);
    }

    public function testShouldLogRenderException(): void
    {
        $attributes = [
            'blockId' => 'abc123',
            'className' => 'my-custom-class',
        ];

        $viewModel = [
            'heading' => 'Hello World',
            'text' => 'Lorem ipsum...',
        ];

        $path = 'testBlockBlockServer.js';
        $context = array_merge($attributes, $viewModel);

        $renderer = $this->createMock(
            Renderer::class,
            function (MockBuilder $builder) {
                $mock = $builder->onlyMethods(['entry'])->getMock();

                $mock->expects($this->once())
                    ->method('entry')
                    ->willThrowException(new Exception('Uh oh!'));

                return $mock;
            }
        );

        $ssr = $this->createMock(
            ServerSideRenderer::class,
            function (MockBuilder $builder) use ($renderer) {
                $mock = $builder->onlyMethods(['isDebugMode', 'getRenderer'])->getMock();

                $mock->expects($this->once())
                    ->method('isDebugMode')
                    ->with()
                    ->willReturn(true);

                $mock->expects($this->once())
                    ->method('getRenderer')
                    ->with()
                    ->willReturn($renderer);

                return $mock;
            }
        );

        $this->mock(
            LogFacade::class,
            function (MockBuilder $builder) use ($path, $context) {
                $mock = $builder->onlyMethods(['debug'])->getMock();

                $mock->expects($this->once())
                    ->method('debug')
                    ->with('Uh oh!', [
                        'path' => $path,
                        'context' => $context,
                    ]);

                return $mock;
            }
        );

        $actual = $ssr->render($path, $context);

        self::assertSame('', $actual);
    }
}
