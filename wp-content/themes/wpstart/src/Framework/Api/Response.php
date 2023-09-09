<?php

declare(strict_types=1);

namespace WPStart\Framework\Api;

/**
 * The response object.
 *
 * @unreleased
 */
class Response
{
    public function __construct(
        public string $status,
        public int $code,
        public ?string $message = null,
        public ?array $data = null,
    ) {
    }
}
