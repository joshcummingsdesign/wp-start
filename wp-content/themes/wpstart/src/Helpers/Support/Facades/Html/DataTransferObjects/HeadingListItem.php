<?php

declare(strict_types=1);

namespace WPStart\Helpers\Support\Facades\Html\DataTransferObjects;

/**
 * @unreleased
 */
class HeadingListItem
{
    public function __construct(
        public string $title,
        public string $slug,
        public string $number,
        /** @var self[] $children */
        public array $children,
    ) {
    }
}
