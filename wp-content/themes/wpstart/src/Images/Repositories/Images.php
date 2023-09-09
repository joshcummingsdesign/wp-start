<?php

declare(strict_types=1);

namespace WPStart\Images\Repositories;

use WPStart\Images\DataTransferObjects\Image;

/**
 * Images repository.
 *
 * @unreleased
 */
class Images
{
    /**
     * Get the image data by ID.
     *
     * @unreleased
     */
    public function getImageData(?string $id, string $size = 'thumbnail'): ?Image
    {
        if (empty($id)) {
            return null;
        }

        $image = wp_get_attachment_image_src((int)$id, $size);

        if (empty($image)) {
            return null;
        }

        return new Image([
            'src' => $image[0],
            'width' => $image[1],
            'height' => $image[2],
            'alt' => get_post_meta($id, '_wp_attachment_image_alt', true),
        ]);
    }
}
