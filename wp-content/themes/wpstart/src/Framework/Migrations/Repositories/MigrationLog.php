<?php

namespace WPStart\Framework\Migrations\Repositories;

use Exception;
use WPStart\Framework\Database\DB;
use WPStart\Framework\Migrations\Models\MigrationLog as MigrationLogModel;
use WPStart\Framework\Migrations\ValueObjects\MigrationLogStatus;

/**
 * The migration log repository.
 *
 * @unreleased
 */
class MigrationLog
{
    /**
     * The migration table.
     *
     * @unreleased
     */
    private string $migration_table;

    /**
     * @unreleased
     */
    public function __construct()
    {
        $this->migration_table = DB::prefix('migrations');
    }

    /**
     * Save migration.
     *
     * @unreleased
     */
    public function save(MigrationLogModel $model): void
    {
        $query = "
            INSERT INTO $this->migration_table (id, status, error, last_run)
            VALUES (%s, %s, %s, NOW())
            ON DUPLICATE KEY UPDATE
            status = %s,
            error = %s,
            last_run = NOW()
        ";

        DB::query(
            DB::prepare(
                $query,
                $model->getId(),
                $model->getStatus()->value,
                $model->getError(),
                $model->getStatus()->value,
                $model->getError()
            )
        );
    }

    /**
     * Get all migrations.
     *
     * @unreleased
     *
     * @return MigrationLogModel[]
     */
    public function getMigrations(): array
    {
        $migrations = [];

        $result = DB::get_results("SELECT * FROM $this->migration_table");

        if ($result) {
            foreach ($result as $migration) {
                $migrations[] = new MigrationLogModel(
                    $migration->id,
                    MigrationLogStatus::from($migration->status),
                    $migration->error,
                    $migration->last_run
                );
            }
        }

        return $migrations;
    }

    /**
     * Get migration by ID.
     *
     * @unreleased
     */
    public function getMigration(string $id): ?MigrationLogModel
    {
        $migration = DB::get_row(
            DB::prepare("SELECT * FROM $this->migration_table WHERE id = %s", $id)
        );

        if ($migration) {
            return new MigrationLogModel(
                $migration->id,
                MigrationLogStatus::from($migration->status),
                $migration->error,
                $migration->last_run
            );
        }

        return null;
    }

    /**
     * Get migrations by status.
     *
     * @unreleased
     *
     * @return MigrationLogModel[]
     */
    public function getMigrationsByStatus(MigrationLogStatus $status): array
    {
        $migrations = [];

        $result = DB::get_results(
            DB::prepare("SELECT * FROM $this->migration_table WHERE status = %s", $status->value)
        );

        if ($result) {
            foreach ($result as $migration) {
                $migrations[] = new MigrationLogModel(
                    $migration->id,
                    MigrationLogStatus::from($migration->status),
                    $migration->error,
                    $migration->last_run
                );
            }
        }

        return $migrations;
    }

    /**
     * Get completed migrations IDs.
     *
     * @unreleased
     *
     * @return string[]
     */
    public function getCompletedMigrationsIDs(): array
    {
        $migrations = [];

        $result = DB::get_results(
            DB::prepare(
                "SELECT * FROM $this->migration_table WHERE status = %s",
                MigrationLogStatus::SUCCESS->value
            )
        );

        if ($result) {
            foreach ($result as $migration) {
                $migrations[] = $migration->id;
            }
        }

        return $migrations;
    }

    /**
     * Get migration count.
     *
     * @unreleased
     */
    public function getMigrationsCount(): ?int
    {
        try {
            return DB::get_var("SELECT count(id) FROM $this->migration_table");
        } catch (Exception $e) {
            return 0;
        }
    }

    /**
     * Get failed migrations count by list of migrations IDs.
     *
     * @unreleased
     */
    public function getFailedMigrationsCountByIds(array $migrationIds): int
    {
        try {
            $query = sprintf(
                "SELECT count(id) FROM %s WHERE id IN ('%s') AND status != '%s'",
                $this->migration_table,
                implode("','", array_map('esc_sql', $migrationIds)),
                MigrationLogStatus::SUCCESS->value
            );

            return DB::get_var($query);
        } catch (Exception $e) {
            return 0;
        }
    }
}
