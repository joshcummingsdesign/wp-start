<?php

namespace WPStart\Framework\Migrations\Models;

use WPStart\Framework\Migrations\Repositories\MigrationLog as MigrationLogRepository;
use WPStart\Framework\Migrations\ValueObjects\MigrationLogStatus;

use function WPStart\Framework\ServiceContainer\app;

/**
 * The migration log model.
 *
 * @unreleased
 */
class MigrationLog
{
    /**
     * The ID.
     *
     * @unreleased
     */
    private string $id;

    /**
     * The status.
     *
     * @unreleased
     */
    private MigrationLogStatus $status;

    /**
     * The last run.
     *
     * @unreleased
     */
    private ?string $last_run;

    /**
     * The error.
     *
     * @unreleased
     */
    private mixed $error;

    /**
     * @unreleased
     */
    public function __construct(
        string $id,
        ?MigrationLogStatus $status = null,
        mixed $error = null,
        ?string $lastRun = null
    ) {
        $this->id = $id;
        $this->last_run = $lastRun;
        $this->setError($error);
        $this->setStatus($status);
    }

    /**
     * Set migration status.
     *
     * Set to failed by default.
     *
     * @unreleased
     */
    public function setStatus(?MigrationLogStatus $status): MigrationLog
    {
        $this->status = $status ?? MigrationLogStatus::FAILED;

        return $this;
    }

    /**
     * Add migration error notice.
     *
     * @unreleased
     */
    public function setError(mixed $error): MigrationLog
    {
        if (is_array($error) || is_object($error)) {
            $error = print_r($error, true);
        }

        $this->error = $error;

        return $this;
    }

    /**
     * Get the ID.
     *
     * @unreleased
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Get the status.
     *
     * @unreleased
     */
    public function getStatus(): MigrationLogStatus
    {
        return $this->status;
    }

    /**
     * Get the last run date.
     *
     * @unreleased
     */
    public function getLastRunDate(): string
    {
        return $this->last_run;
    }

    /**
     * Get the error.
     *
     * @unreleased
     */
    public function getError(): mixed
    {
        return $this->error;
    }

    /**
     * Save migration
     *
     * @unreleased
     */
    public function save(): void
    {
        app(MigrationLogRepository::class)->save($this);
    }
}
