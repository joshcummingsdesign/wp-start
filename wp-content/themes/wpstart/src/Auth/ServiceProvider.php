<?php

declare(strict_types=1);

namespace WPStart\Auth;

use WPStart\Auth\Actions\AddCheckForE2EAuthCookie;
use WPStart\Framework\Core\Hooks;
use WPStart\Framework\ServiceProviders\Contracts\ServiceProvider as ServiceProviderContract;

/**
 * The auth service provider.
 *
 * @unreleased
 */
class ServiceProvider extends ServiceProviderContract {
  /**
   * {@inheritDoc}
   *
   * @unreleased
   */
  public function register(): void {
  }

  /**
   * {@inheritDoc}
   *
   * @unreleased
   */
  public function boot(): void {
    Hooks::addAction('template_redirect', AddCheckForE2EAuthCookie::class);
  }
}
