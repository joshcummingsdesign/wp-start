<?php

declare(strict_types=1);

namespace Tests\Unit\Framework\Assets\Stubs;

use WPStart\Framework\Assets\Contracts\Style as StyleContract;

class PostStyle extends StyleContract
{
    public function getContexts(): array
    {
        return ['posts'];
    }

    public function getHandle(): string
    {
        return 'wpstart/test-post';
    }

    public function getPath(): string
    {
        return 'test-post.css';
    }
}
