<?php

declare(strict_types=1);

namespace WPStart\Framework\Migrations\ConsoleCommands;

use WPStart\Framework\Console\Contracts\ConsoleCommand;
use WPStart\Framework\Migrations\MigrationsRunner;

use function WPStart\Framework\ServiceContainer\app;

/**
 * The run migrations command.
 *
 * @unreleased
 */
class RunMigrations extends ConsoleCommand
{
    /**
     * {@inheritDoc}
     *
     * @unreleased
     */
    public function getCommand(): string
    {
        return 'migrations run';
    }

    /**
     * {@inheritDoc}
     *
     * @unreleased
     */
    public function run(): void
    {
        /** @var MigrationsRunner $commandsRegister */
        $migrationsRunner = app(MigrationsRunner::class);
        $migrationsRunner->run();
    }
}
