<?php

declare(strict_types=1);

namespace WPStart\Framework\Log\Facades;

use OutOfBoundsException;
use Sentry\Severity;
use Sentry\State\Scope;

use function Sentry\captureMessage;
use function Sentry\withScope;

/**
 * Log facade.
 *
 * @unreleased
 */
class LogFacade
{
    /**
     * Log level debug.
     *
     * @unreleased
     */
    const DEBUG = 1;

    /**
     * Log level info.
     *
     * @unreleased
     */
    const INFO = 2;

    /**
     * Log level warning.
     *
     * @unreleased
     */
    const WARNING = 3;

    /**
     * Log level error.
     *
     * @unreleased
     */
    const ERROR = 4;

    /**
     * Log level critical.
     *
     * @unreleased
     */
    const CRITICAL = 5;

    /**
     * Get the log level.
     *
     * Uses the GIVE_LOG_LEVEL constant. Defaults to 3.
     *
     * @unreleased
     *
     * @throws OutOfBoundsException
     */
    private function getLogLevel(): int
    {
        if ( ! defined('GIVE_LOG_LEVEL')) {
            return 3;
        }

        if (GIVE_LOG_LEVEL < self::DEBUG || GIVE_LOG_LEVEL > self::CRITICAL) {
            throw new OutOfBoundsException('Invalid log level: ' . GIVE_LOG_LEVEL);
        }

        return GIVE_LOG_LEVEL;
    }

    /**
     * Checks if Sentry is enabled.
     *
     * @unreleased
     */
    private function sentryIsEnabled(): bool
    {
        return function_exists('Sentry\\captureMessage') && defined('SENTRY_DSN');
    }

    /**
     * Send data to Sentry.
     *
     * @unreleased
     */
    private function sendToSentry(string $message, array $context, Severity $severity): void
    {
        if ( ! $this->sentryIsEnabled()) {
            return;
        }

        withScope(function (Scope $scope) use ($message, $context, $severity): void {
            $scope->setContext('Context', $context);
            $scope->setLevel($severity);

            if (function_exists('is_user_logged_in') && is_user_logged_in() && ($user = wp_get_current_user())) {
                $scope->setUser([
                    'id' => $user->ID,
                    'username' => $user->user_login,
                    'email' => wp_get_current_user()->user_email,
                ]);
            }

            captureMessage("Log: $message");
        });
    }

    /**
     * Send a debug log to Sentry.
     *
     * Used for detailed debug information.
     *
     * @unreleased
     */
    public function debug(string $message, array $context = []): void
    {
        if ($this->getLogLevel() === self::DEBUG) {
            $this->sendToSentry($message, $context, Severity::debug());
        }
    }

    /**
     * Send an info log to Sentry.
     *
     * Used for interesting events (e.g. user logs in, SQL logs).
     *
     * @unreleased
     */
    public function info(string $message, array $context = []): void
    {
        if ($this->getLogLevel() <= self::INFO) {
            $this->sendToSentry($message, $context, Severity::info());
        }
    }

    /**
     * Send a warning to Sentry.
     *
     * Used for exceptional occurrences that are not
     * errors (e.g. deprecated APIs, poor use of API).
     *
     * @unreleased
     */
    public function warning(string $message, array $context = []): void
    {
        if ($this->getLogLevel() <= self::WARNING) {
            $this->sendToSentry($message, $context, Severity::warning());
        }
    }

    /**
     * Send an error to Sentry.
     *
     * Used for runtime errors that do not require immediate
     * action, but should typically be logged and monitored.
     *
     * @unreleased
     */
    public function error(string $message, array $context = []): void
    {
        if ($this->getLogLevel() <= self::ERROR) {
            $this->sendToSentry($message, $context, Severity::error());
        }
    }

    /**
     * Send a fatal error to Sentry.
     *
     * Used for critical conditions (e.g. application
     * component unavailable, unexpected exception).
     *
     * @unreleased
     */
    public function fatal(string $message, array $context = []): void
    {
        if ($this->getLogLevel() <= self::CRITICAL) {
            $this->sendToSentry($message, $context, Severity::fatal());
        }
    }
}
