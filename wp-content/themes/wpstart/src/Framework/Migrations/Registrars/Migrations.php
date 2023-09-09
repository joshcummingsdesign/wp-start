<?php

namespace WPStart\Framework\Migrations\Registrars;

use InvalidArgumentException;
use WPStart\Framework\Migrations\Contracts\Migration;

use function WPStart\Framework\ServiceContainer\app;

/**
 * Migrations registrar.
 *
 * @unreleased
 */
class Migrations
{
    /**
     * Migrations registry.
     *
     * @unreleased
     *
     * @var array<string, string> [ $migrationId => Fully-qualified Migration class name ]
     */
    private array $migrations = [];

    /**
     * Get all the registered migrations.
     *
     * @unreleased
     *
     * @return array<string, string> [ $migrationId => Fully-qualified Migration class name ]
     */
    public function get(): array
    {
        return $this->migrations;
    }

    /**
     * Checks to see if a migration is registered with the given ID.
     *
     * @unreleased
     */
    public function has(string $id): bool
    {
        return isset($this->migrations[$id]);
    }

    /**
     * Returns a migration with the given ID.
     *
     * @unreleased
     */
    public function getOne(string $id): string
    {
        if ( ! isset($this->migrations[$id])) {
            throw new InvalidArgumentException("No migration exists with the ID $id");
        }

        return $this->migrations[$id];
    }

    /**
     * Get all the registered migration IDs.
     *
     * @unreleased
     *
     * @return string[]
     */
    public function getRegisteredIds(): array
    {
        return array_keys($this->migrations);
    }

    /**
     * Add a migration to the registry.
     *
     * @unreleased
     *
     * @param string $migration Fully-qualified Migration class name.
     */
    public function addOne(string $migration): void
    {
        if ( ! is_subclass_of($migration, Migration::class)) {
            throw new InvalidArgumentException("$migration must extend " . Migration::class);
        }

        /** @var Migration $instance */
        $instance = app($migration);
        $migrationId = $instance::id();

        if (isset($this->migrations[$migrationId])) {
            throw new InvalidArgumentException('A migration can only be added once. Make sure there are not id conflicts.');
        }

        $this->migrations[$migrationId] = $migration;
    }

    /**
     * Add multiple migrations to the registry.
     *
     * @unreleased
     *
     * @param string[] $migrations Array of fully-qualified Migration class names.
     */
    public function add(array $migrations): void
    {
        foreach ($migrations as $migration) {
            $this->addOne($migration);
        }
    }
}
