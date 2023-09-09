<?php

declare(strict_types=1);

namespace Tests\Unit\Helpers\Support\Facades\Str;

use WPStart\Helpers\Support\Facades\Str\Str;
use Tests\TestCase;

/**
 * Test the Str facade.
 */
final class StrTest extends TestCase
{
    public function testShouldValidateUuid(): void
    {
        self::assertTrue(Str::isValidUuid('dc330c50-9eb5-450a-99af-ec8d0dd5ec56'));
        self::assertTrue(Str::isValidUuid('28629152-792b-42d2-8067-9632490d0958'));
        self::assertFalse(Str::isValidUuid('28629152-792b-42d2-8067-9632490d'));
        self::assertFalse(Str::isValidUuid('Hello World'));
    }

    public function testShouldSlugifyHeading(): void
    {
        self::assertEquals('hello-world', Str::slugify('Hello World'));
        self::assertEquals('this-is-a-heading-woohoo', Str::slugify('This, is a heading!*@$# Woohoo'));
        self::assertEquals('h-hello-world', Str::slugify('Hello World', 'h'));
        self::assertEquals('h-this-is-a-heading-woohoo', Str::slugify('This, is a heading!*@$# Woohoo', 'h'));
    }

    public function testShouldTrimExcerpt(): void
    {
        self::assertEquals(
            'Hello world.',
            Str::trimSentence('Hello world. Goodnight moon.', 11)
        );

        self::assertEquals(
            'Lorem ipsum. Hello world?',
            Str::trimSentence('Lorem ipsum. Hello world? Goodnight Moon!', 15)
        );

        self::assertEquals(
            'Lorem ipsum.',
            Str::trimSentence('Lorem ipsum. Hello world? Goodnight Moon!', 12)
        );
    }
}
