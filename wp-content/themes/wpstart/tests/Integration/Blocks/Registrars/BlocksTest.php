<?php

declare(strict_types=1);

namespace Tests\Integration\Blocks\Registrars;

use PHPUnit\Framework\MockObject\MockBuilder;
use WPStart\Blocks\Registrars\Blocks;
use Tests\TestCase;
use Tests\Unit\Blocks\Stubs\Block1;

/**
 * Test the blocks registrar.
 */
final class BlocksTest extends TestCase
{
    public function testShouldEnqueueEditorAssets(): void
    {
        $userId = self::factory()->user->create(['role' => 'administrator']);
        wp_set_current_user($userId);
        set_current_screen('edit-post');

        $block = $this->createMock(
            Block1::class,
            function (MockBuilder $builder) {
                $mock = $builder->onlyMethods(['enqueueEditorAssets'])->getMock();

                $mock->expects($this->once())
                    ->method('enqueueEditorAssets')
                    ->with();

                return $mock;
            }
        );

        $blocks = $this->createMock(
            Blocks::class,
            function (MockBuilder $builder) use ($block) {
                $mock = $builder->onlyMethods(['getRegisteredBlocks'])->getMock();

                $mock->expects($this->once())
                    ->method('getRegisteredBlocks')
                    ->with()
                    ->willReturn([$block::class => $block]);

                return $mock;
            }
        );

        $blocks->enqueueEditorAssets();
    }
}
