<?php

declare(strict_types=1);

namespace WPStart\Framework\Migrations;

use WPStart\Framework\Console\Registrars\ConsoleCommands;
use WPStart\Framework\Migrations\ConsoleCommands\RunMigrations;
use WPStart\Framework\ServiceProviders\Contracts\ServiceProvider as ServiceProviderContract;

use function WPStart\Framework\ServiceContainer\app;

/**
 * The migrations service provider.
 *
 * @unreleased
 */
class ServiceProvider extends ServiceProviderContract
{
    /**
     * {@inheritDoc}
     *
     * @unreleased
     */
    public function register(): void
    {
    }

    /**
     * {@inheritDoc}
     *
     * @unreleased
     */
    public function boot(): void
    {
        $this->registerConsoleCommands();
    }

    /**
     * Register console commands.
     *
     * @unreleased
     */
    private function registerConsoleCommands(): void
    {
        /** @var ConsoleCommands $commands */
        $commands = app(ConsoleCommands::class);

        $commands->add([
            RunMigrations::class,
        ]);
    }
}
