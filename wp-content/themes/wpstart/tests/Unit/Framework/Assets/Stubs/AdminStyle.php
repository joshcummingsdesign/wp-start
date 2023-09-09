<?php

declare(strict_types=1);

namespace Tests\Unit\Framework\Assets\Stubs;

use WPStart\Framework\Assets\Contracts\Style as StyleContract;

class AdminStyle extends StyleContract
{
    public function getContexts(): array
    {
        return ['admin'];
    }

    public function getHandle(): string
    {
        return 'wpstart/admin';
    }

    public function getPath(): string
    {
        return 'admin.css';
    }
}
