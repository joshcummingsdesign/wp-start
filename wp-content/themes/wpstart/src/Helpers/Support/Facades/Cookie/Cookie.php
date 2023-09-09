<?php

declare(strict_types=1);

namespace WPStart\Helpers\Support\Facades\Cookie;

use WPStart\Framework\Facades\Facade;

/**
 * Cookie facade.
 *
 * @unreleased
 *
 * @method static void set(string $name, string $value = '', int $expiresOrOptions = 0, string $path = '', string $domain = '', bool $secure = false, bool $httpOnly = false)
 * @method static string|null get(string $name)
 */
class Cookie extends Facade {
  /**
   * {@inheritDoc}
   *
   * @unreleased
   */
  protected function getFacadeAccessor(): string {
    return CookieFacade::class;
  }
}
