<?php

declare(strict_types=1);

namespace WPStart\Framework\Debug\Facades;

/**
 * The debug facade.
 *
 * @unreleased
 */
class Debug
{
    /**
     * Print a value for debugging purposes.
     *
     * @unreleased
     */
    public static function print(mixed $val): void
    {
        echo '<div style="background-color: white; padding: 100px 20px; overflow: auto;">';
        highlight_string("<?php\n\$val =\n" . var_export($val, true) . ";\n?>");
        echo '</div>';
    }
}
