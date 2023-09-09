<?php

declare(strict_types=1);

namespace Tests\Unit\Blocks\Registrars;

use PHPUnit\Framework\MockObject\MockBuilder;
use WPStart\Blocks\Registrars\Blocks;
use Tests\TestCase;
use Tests\Unit\Blocks\Stubs\Block1;
use Tests\Unit\Blocks\Stubs\Block2;

/**
 * Test the blocks registrar.
 */
final class BlocksTest extends TestCase
{
    public function testShouldNotEnqueueEditorAssetsOnFrontend(): void
    {
        $blocks = $this->createMock(
            Blocks::class,
            function (MockBuilder $builder) {
                $mock = $builder->onlyMethods(['getRegisteredBlocks'])->getMock();

                $mock->expects($this->never())->method('getRegisteredBlocks');

                return $mock;
            }
        );

        $blocks->enqueueEditorAssets();
    }

    public function testShouldEnqueueAssets(): void
    {
        $block1 = $this->createMock(
            Block1::class,
            function (MockBuilder $builder) {
                $mock = $builder->onlyMethods(['getContexts', 'enqueueAssets'])->getMock();

                $mock->expects($this->once())
                    ->method('getContexts')
                    ->with()
                    ->willReturn(['global']);

                $mock->expects($this->once())
                    ->method('enqueueAssets')
                    ->with();

                return $mock;
            }
        );

        $block2 = $this->createMock(
            Block2::class,
            function (MockBuilder $builder) {
                $mock = $builder->onlyMethods(['getContexts', 'enqueueAssets'])->getMock();

                $mock->expects($this->once())
                    ->method('getContexts')
                    ->with()
                    ->willReturn(['post']);

                $mock->expects($this->never())->method('enqueueAssets');

                return $mock;
            }
        );

        $blocks = $this->createMock(
            Blocks::class,
            function (MockBuilder $builder) use ($block1, $block2) {
                $mock = $builder->onlyMethods(['getRegisteredBlocks'])->getMock();

                $mock->expects($this->once())
                    ->method('getRegisteredBlocks')
                    ->with()
                    ->willReturn([
                        $block1::class => $block1,
                        $block2::class => $block2,
                    ]);

                return $mock;
            }
        );

        $blocks->enqueueAssets();
    }
}
