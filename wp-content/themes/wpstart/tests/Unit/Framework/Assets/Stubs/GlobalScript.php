<?php

declare(strict_types=1);

namespace Tests\Unit\Framework\Assets\Stubs;

use WPStart\Framework\Assets\Contracts\Script as ScriptContract;

class GlobalScript extends ScriptContract
{
    public function getContexts(): array
    {
        return ['global'];
    }

    public function getHandle(): string
    {
        return 'wpstart/test-global';
    }

    public function getPath(): string
    {
        return 'test-global.js';
    }
}
