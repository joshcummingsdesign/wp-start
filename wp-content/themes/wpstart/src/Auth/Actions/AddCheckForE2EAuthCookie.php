<?php

declare(strict_types=1);

namespace WPStart\Auth\Actions;

use JetBrains\PhpStorm\NoReturn;
use WPStart\Helpers\Support\Facades\Cookie\Cookie;

/**
 * Restrict access to the website if the `E2E_AUTH_KEY` constant
 * is defined. If the constant is defined, access will be granted if
 * the value of a cookie called `e2e_auth_key` matches the value of the
 * constant. This is only for use with the e2e testing environment.
 *
 * @unreleased
 */
class AddCheckForE2EAuthCookie
{
    public function __invoke(): void
    {
        // If constant is not set, allow access.
        if ( ! defined('E2E_AUTH_KEY')) {
            return;
        }

        // If cookie is set, and it matches the constant, allow access.
        if (Cookie::get('e2e_auth_key') === E2E_AUTH_KEY) {
            return;
        }

        // Otherwise, restrict access.
        $this->sendRestrictedAccessHtml();
    }

    /**
     * Send restricted access HTML.
     *
     * @unreleased
     */
    #[NoReturn]
    protected function sendRestrictedAccessHtml(): void
    {
        ob_start(); ?>
        <!doctype html>
        <html lang="en">
            <head>
                <title>Restricted Access</title>
                <meta name="robots" content="noindex,nofollow">
            </head>
            <body>
                <p>Restricted Access</p>
            </body>
        </html>
        <?php
        echo ob_get_clean();

        die();
    }
}
