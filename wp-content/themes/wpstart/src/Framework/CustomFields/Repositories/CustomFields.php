<?php

declare(strict_types=1);

namespace WPStart\Framework\CustomFields\Repositories;

/**
 * Custom fields repository.
 *
 * @unreleased
 */
class CustomFields
{
    /**
     * Get option.
     *
     * @unreleased
     */
    public function getOption(string $name): mixed
    {
        return carbon_get_theme_option($name);
    }

    /**
     * Get post meta.
     *
     * @unreleased
     */
    public function getPostMeta(string $name, int $postId): mixed
    {
        return carbon_get_post_meta($postId, $name);
    }

    /**
     * Get nav menu item meta.
     *
     * @unreleased
     */
    public function getNavMenuItemMeta(string $name, int $itemId): mixed
    {
        return carbon_get_nav_menu_item_meta($itemId, $name);
    }

    /**
     * Get user meta.
     *
     * @unreleased
     */
    public function getUserMeta(string $name, int $userId): mixed
    {
        return carbon_get_user_meta($userId, $name);
    }
}
