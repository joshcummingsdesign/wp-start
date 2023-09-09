<?php

declare(strict_types=1);

namespace WPStart\Framework\Database;

use WPStart\Framework\Database\Exceptions\DatabaseQueryException;
use WP_Error;

/**
 * The database facade.
 *
 * A static decorator for the $wpdb class and decorator function
 * which does SQL error checking when performing queries. If an
 * SQL error occurs a DatabaseQueryException is thrown.
 *
 * @unreleased
 *
 * @method static int|bool query(string $query)
 * @method static int|false insert(string $table, array $data, array|string|null $format = null)
 * @method static int|false delete(string $table, array $where, array|string|null $where_format = null)
 * @method static int|false update(string $table, array $data, array $where, array|string|null $format = null, array|string|null $where_format = null)
 * @method static int|false replace(string $table, array $data, array|string|null $format = null)
 * @method static string|null get_var(string|null $query = null, int $x = 0, int $y = 0)
 * @method static array|object|null|void get_row(string|null $query = null, string $output = OBJECT, int $y = 0)
 * @method static array get_col(string|null $query = null, int $x = 0)
 * @method static array|object|null get_results(string|null $query = null, string $output = OBJECT)
 * @method static string get_charset_collate()
 */
class DB
{
    /**
     * Runs the dbDelta function and returns a WP_Error
     * with any errors that occurred during the process.
     *
     * @see    dbDelta()
     *
     * @unreleased
     *
     * @param string|string[] $delta
     *
     * @throws DatabaseQueryException
     */
    public static function delta(string|array $delta): array
    {
        return self::runQueryWithErrorChecking(
            static function () use ($delta) {
                return dbDelta($delta);
            }
        );
    }

    /**
     * A convenience method for the $wpdb->prepare method.
     *
     * @see   WPDB::prepare()
     *
     * @unreleased
     */
    public static function prepare(string $query, mixed ...$args): string
    {
        global $wpdb;

        return $wpdb->prepare($query, ...$args);
    }

    /**
     * Magic method which calls the static method
     * on the $wpdb while performing error checking.
     *
     * @unreleased
     *
     * @throws DatabaseQueryException
     */
    public static function __callStatic(string $name, array $arguments): mixed
    {
        return self::runQueryWithErrorChecking(
            static function () use ($name, $arguments) {
                global $wpdb;

                return call_user_func_array([$wpdb, $name], $arguments);
            }
        );
    }

    /**
     * Get last insert ID.
     *
     * @unreleased
     */
    public static function lastInsertId(): int
    {
        global $wpdb;

        return $wpdb->insert_id;
    }

    /**
     * Runs a query callable and checks to see if any
     * unique SQL errors occurred when it was run.
     *
     * @unreleased
     *
     * @throws DatabaseQueryException
     */
    private static function runQueryWithErrorChecking(callable $queryCaller): mixed
    {
        global $wpdb, $EZSQL_ERROR;
        require_once ABSPATH . 'wp-admin/includes/upgrade.php';

        $errorCount = is_array($EZSQL_ERROR) ? count($EZSQL_ERROR) : 0;
        $hasShowErrors = $wpdb->hide_errors();

        $output = $queryCaller();

        if ($hasShowErrors) {
            $wpdb->show_errors();
        }

        $wpError = self::getQueryErrors($errorCount);

        if ( ! empty($wpError->errors)) {
            throw DatabaseQueryException::create($wpError->get_error_messages());
        }

        return $output;
    }

    /**
     * Retrieves the SQL errors stored by WordPress.
     *
     * @unreleased
     */
    private static function getQueryErrors(int $initialCount = 0): WP_Error
    {
        global $EZSQL_ERROR;

        $wpError = new WP_Error();

        if (is_array($EZSQL_ERROR)) {
            for ($index = $initialCount, $indexMax = count($EZSQL_ERROR); $index < $indexMax; $index++) {
                $error = $EZSQL_ERROR[$index];

                if (empty($error['error_str'])
                    || empty($error['query'])
                    || str_starts_with($error['query'], 'DESCRIBE ')) {
                    continue;
                }

                $wpError->add('db_delta_error', $error['error_str']);
            }
        }

        return $wpError;
    }

    /**
     * Prefix given table name with $wpdb->prefix.
     *
     * @unreleased
     */
    public static function prefix(string $tableName): string
    {
        global $wpdb;

        return $wpdb->prefix . $tableName;
    }
}
