<?php

use WPStart\Main;

use function WPStart\Framework\ServiceContainer\app;

// Exit if accessed directly.
if ( ! defined('ABSPATH')) {
    exit;
}

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/vendor/vendor-prefixed/autoload.php';

app(Main::class)->boot();
