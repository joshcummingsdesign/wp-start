<?php

declare(strict_types=1);

namespace WPStart\Framework\Console\Contracts;

/**
 * The console command abstract class.
 *
 * @unreleased
 */
abstract class ConsoleCommand
{
    /**
     * Get the command string.
     *
     * @unreleased
     */
    abstract public function getCommand(): string;

    /**
     * Run the command.
     *
     * @unreleased
     */
    abstract public function run(): void;
}
