<?php

declare(strict_types=1);

namespace WPStart\Helpers\Support\Facades\Str;

use WPStart\Framework\Facades\Facade;

/**
 * Str facade.
 *
 * @unreleased
 *
 * @method static string generateUuid()
 * @method static bool isValidUuid(string $uuid)
 * @method static string slugify(string $str, string $prefix = '')
 * @method static string trimSentence(string $content, int $letterCount)
 */
class Str extends Facade
{
    /**
     * {@inheritDoc}
     *
     * @unreleased
     */
    protected function getFacadeAccessor(): string
    {
        return StrFacade::class;
    }
}
