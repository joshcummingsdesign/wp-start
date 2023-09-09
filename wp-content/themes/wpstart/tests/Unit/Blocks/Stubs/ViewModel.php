<?php

declare(strict_types=1);

namespace Tests\Unit\Blocks\Stubs;

use WPStart\Framework\ViewModels\Contracts\ViewModel as ViewModelContract;

// Check how many times build is called
$i = 0;

class ViewModel extends ViewModelContract
{
    public string $heading;
    public string $text;
    public int $numCalled;

    public static function build(): self
    {
        global $i;

        $instance = new self();

        $instance->heading = 'Hello World';
        $instance->text = 'Lorem ipsum...';
        $instance->numCalled = $i++;

        return $instance;
    }
}
