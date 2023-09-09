<?php

declare(strict_types=1);

namespace WPStart\Helpers\Support\Facades\Cookie;

/**
 * Cookie facade.
 *
 * @unreleased
 */
class CookieFacade {
  /**
   * Set a cookie
   *
   * @unreleased
   */
  public function set(
    string $name,
    string $value = '',
    int $expiresOrOptions = 0,
    string $path = '',
    string $domain = '',
    bool $secure = false,
    bool $httpOnly = false
  ): void {
    setcookie($name, $value, $expiresOrOptions, $path, $domain, $secure, $httpOnly);
  }

  /**
   * Get a cookie
   *
   * @unreleased
   */
  public function get(string $name): ?string {
    return $_COOKIE[$name] ?? null;
  }
}
