<?php

namespace WPStart\Framework\Migrations;

use Exception;
use WPStart\Framework\Database\DB;
use WPStart\Framework\Database\Exceptions\DatabaseQueryException;
use WPStart\Framework\Log\Facades\Log;
use WPStart\Framework\Migrations\Contracts\Migration;
use WPStart\Framework\Migrations\Models\MigrationLog as MigrationLogModel;
use WPStart\Framework\Migrations\Registrars\Migrations as MigrationsRegistrar;
use WPStart\Framework\Migrations\Repositories\MigrationLog as MigrationLogRepository;
use WPStart\Framework\Migrations\ValueObjects\MigrationLogStatus;

use function WPStart\Framework\ServiceContainer\app;

/**
 * The migrations runner class.
 *
 * @unreleased
 */
class MigrationsRunner
{
    /**
     * List of completed migration IDs.
     *
     * @unreleased
     *
     * @var string[]
     */
    private array $completedMigrations;

    /**
     * The MigrationsRegister instance.
     *
     * @unreleased
     */
    private MigrationsRegistrar $migrationsRegistrar;

    /**
     * The MigrationsLogRepository instance.
     *
     * @unreleased
     */
    private MigrationLogRepository $migrationLogRepository;

    /**
     * @unreleased
     */
    public function __construct(
        MigrationsRegistrar $migrationsRegistrar,
        MigrationLogRepository $migrationLogRepository
    ) {
        $this->migrationsRegistrar = $migrationsRegistrar;
        $this->migrationLogRepository = $migrationLogRepository;
        $this->completedMigrations = $this->migrationLogRepository->getCompletedMigrationsIDs();
    }

    /**
     * Run database migrations.
     *
     * @unreleased
     */
    public function run(): void
    {
        if ( ! $this->hasMigrationToRun()) {
            return;
        }

        // Stop Migration Runner if there are failed migrations
        if ($this->migrationLogRepository->getFailedMigrationsCountByIds(
            $this->migrationsRegistrar->getRegisteredIds()
        )) {
            return;
        }

        // Store and sort migrations by timestamp
        $migrations = [];

        foreach ($this->migrationsRegistrar->get() as $migrationClass) {
            /* @var Migration $migration */
            $migration = app($migrationClass);
            $migrations[$migration::timestamp() . '_' . $migration::id()] = $migration;
        }

        ksort($migrations);

        foreach ($migrations as $migration) {
            $migrationId = $migration::id();

            if (in_array($migrationId, $this->completedMigrations, true)) {
                continue;
            }

            $migrationLog = new MigrationLogModel($migrationId);

            // Begin transaction
            DB::query('START TRANSACTION');

            try {
                $migration->run();

                // Save migration status
                $migrationLog->setStatus(MigrationLogStatus::SUCCESS);
            } catch (Exception $e) {
                DB::query('ROLLBACK');

                $migrationLog->setStatus(MigrationLogStatus::FAILED);
                $migrationLog->setError($e);

                Log::error(
                    'There was a problem running the migrations.',
                    ['exception' => $e->getMessage()]
                );

                break;
            }

            try {
                $migrationLog->save();
            } catch (DatabaseQueryException $e) {
                Log::error(
                    'Failed to save migration log.',
                    [
                        'Error Message' => $e->getMessage(),
                        'Query Errors' => $e->getQueryErrors(),
                    ]
                );
            }

            // Commit transaction if successful
            DB::query('COMMIT');
        }
    }

    /**
     * Return whether all migrations have completed.
     *
     * @unreleased
     */
    public function hasMigrationToRun(): bool
    {
        return (bool)array_diff(
            $this->migrationsRegistrar->getRegisteredIds(),
            $this->completedMigrations
        );
    }
}
