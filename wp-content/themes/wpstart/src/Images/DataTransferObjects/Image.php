<?php

namespace WPStart\Images\DataTransferObjects;

/*
 * The image data transfer object.
 *
 * @unreleased
 */

class Image
{
    public function __construct(
        public string $src,
        public int $width,
        public int $height,
        public string $alt,
    ) {
    }


    /**
     * Get an empty instance.
     *
     * @unreleased
     */
    public static function empty(): self
    {
        return new self(
            src: '',
            width: 0,
            height: 0,
            alt: '',
        );
    }
}
