<?php

declare(strict_types=1);

namespace WPStart\Blocks\Actions;

/**
 * Add custom block categories.
 *
 * @unreleased
 */
class AddBlockCategories
{
    public function __invoke(array $categories): array
    {
        return [
            [
                'slug' => 'wpstart-blocks',
                'title' => 'WP Start Blocks',
            ],
            ...$categories,
        ];
    }
}
