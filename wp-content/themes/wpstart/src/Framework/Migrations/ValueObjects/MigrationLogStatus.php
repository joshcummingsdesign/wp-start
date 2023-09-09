<?php

namespace WPStart\Framework\Migrations\ValueObjects;

/**
 * The migration log status enum.
 *
 * @unreleased
 */
enum MigrationLogStatus: string
{
    case SUCCESS = 'success';
    case FAILED = 'failed';
}
