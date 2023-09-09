<?php

declare(strict_types=1);

namespace Tests\Unit\Framework\Assets\Registrars;

use Tests\TestCase;
use Tests\Unit\Framework\Assets\Stubs\GlobalScript;
use Tests\Unit\Framework\Assets\Stubs\GlobalStyle;
use Tests\Unit\Framework\Assets\Stubs\PostScript;
use Tests\Unit\Framework\Assets\Stubs\PostStyle;
use WPStart\Framework\Assets\DataTransferObjects\AssetContext;
use WPStart\Framework\Assets\Registrars\Assets;

/**
 * Test the assets registrar.
 */
final class AssetsTest extends TestCase
{
    public function testShouldAddOneScript(): void
    {
        $registrar = new Assets();

        self::assertEquals([], $registrar->get());

        $registrar->addOneScript(GlobalScript::class);

        $expected = [
            'global' => new AssetContext(
                scripts: [GlobalScript::class],
                styles: [],
            ),
        ];

        self::assertEquals($expected, $registrar->get());
    }

    public function testShouldAddScripts(): void
    {
        $registrar = new Assets();

        self::assertEquals([], $registrar->get());

        $registrar->addScripts([GlobalScript::class, PostScript::class]);

        $expected = [
            'global' => new AssetContext(
                scripts: [GlobalScript::class],
                styles: [],
            ),
            'posts' => new AssetContext(
                scripts: [PostScript::class],
                styles: [],
            ),
        ];

        self::assertEquals($expected, $registrar->get());
    }

    public function testShouldAddOneStyle(): void
    {
        $registrar = new Assets();

        self::assertEquals([], $registrar->get());

        $registrar->addOneStyle(GlobalStyle::class);

        $expected = [
            'global' => new AssetContext(
                scripts: [],
                styles: [GlobalStyle::class],
            ),
        ];

        self::assertEquals($expected, $registrar->get());
    }

    public function testShouldAddStyles(): void
    {
        $registrar = new Assets();

        self::assertEquals([], $registrar->get());

        $registrar->addStyles([GlobalStyle::class, PostStyle::class]);

        $expected = [
            'global' => new AssetContext(
                scripts: [],
                styles: [GlobalStyle::class],
            ),
            'posts' => new AssetContext(
                scripts: [],
                styles: [PostStyle::class],
            ),
        ];

        self::assertEquals($expected, $registrar->get());
    }
}
