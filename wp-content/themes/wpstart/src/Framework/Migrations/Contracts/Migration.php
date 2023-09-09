<?php

namespace WPStart\Framework\Migrations\Contracts;

/**
 * Migration abstract class.
 *
 * @unreleased
 */
abstract class Migration
{
    /**
     * Return a unique identifier for the migration.
     *
     * @unreleased
     */
    abstract public static function id(): string;

    /**
     * Return a Unix Timestamp for when the migration was created.
     *
     * Example: strtotime('2020-09-16 12:30:00')
     *
     * @unreleased
     *
     * @return int Unix timestamp for when the migration was created.
     */
    abstract public static function timestamp(): int;

    /**
     * Bootstrap migration logic.
     *
     * @unreleased
     */
    abstract public function run(): void;
}
