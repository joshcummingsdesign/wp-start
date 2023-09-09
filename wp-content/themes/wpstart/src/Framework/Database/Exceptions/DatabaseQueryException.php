<?php

namespace WPStart\Framework\Database\Exceptions;

use Exception;

/**
 * Database query exception class.
 *
 * @unreleased
 */
class DatabaseQueryException extends Exception
{
    /**
     * The query errors.
     *
     * @unreleased
     *
     * @var string[]
     */
    private array $queryErrors;

    /**
     * Creates a new instance wih the query errors.
     *
     * @unreleased
     *
     * @param string|string[] $queryErrors
     * @param ?string         $message
     *
     * @return DatabaseQueryException
     */
    public static function create($queryErrors, ?string $message = null): self
    {
        $error = new self();

        $error->message = $message ?: 'Query failed in database';
        $error->queryErrors = (array)$queryErrors;

        return $error;
    }

    /**
     * Returns the query errors.
     *
     * @unreleased
     *
     * @return string[]
     */
    public function getQueryErrors(): array
    {
        return $this->queryErrors;
    }

    /**
     * Returns a human-readable form of the exception for logging.
     *
     * @unreleased
     */
    public function getLogOutput(): string
    {
        $queryErrors = print_r(array_map(
            static function ($error) {
                return " - $error";
            },
            $this->queryErrors
        ), true);

        return "
			Code: {$this->getCode()}\n
			Message: {$this->getMessage()}\n
			DB Errors: \n
			$queryErrors
		";
    }
}
