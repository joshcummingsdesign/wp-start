<?php

declare(strict_types=1);

namespace WPStart\Framework\Console\Registrars;

use InvalidArgumentException;
use WPStart\Framework\Console\Contracts\ConsoleCommand;
use WP_CLI;

use function WPStart\Framework\ServiceContainer\app;

/**
 * Commands registrar.
 *
 * @unreleased
 */
class ConsoleCommands
{
    /**
     * Commands registry.
     *
     * @unreleased
     *
     * @var string[] Array of fully-qualified Command class names.
     */
    private array $commands = [];

    /**
     * Get all the registered commands.
     *
     * @unreleased
     *
     * @return string[]
     */
    public function getAll(): array
    {
        return $this->commands;
    }

    /**
     * Add a command to the registry.
     *
     * @unreleased
     *
     * @param string $command Fully-qualified Command class name.
     */
    public function addOne(string $command): void
    {
        if ( ! is_subclass_of($command, ConsoleCommand::class)) {
            throw new InvalidArgumentException("$command must extend " . ConsoleCommand::class);
        }

        $this->commands[] = $command;
    }

    /**
     * Add commands to the registry.
     *
     * @unreleased
     *
     * @param string[] $commands Array of fully-qualified Command class names.
     */
    public function add(array $commands): void
    {
        foreach ($commands as $command) {
            $this->addOne($command);
        }
    }

    /**
     * Register commands.
     *
     * @unreleased
     */
    public function register(): void
    {
        if (defined('WP_CLI') && WP_CLI) {
            $commands = $this->getAll();

            foreach ($commands as $command) {
                /** @var ConsoleCommand $instance */
                $instance = app($command);
                WP_CLI::add_command($instance->getCommand(), [$instance, 'run']);
            }
        }
    }
}
