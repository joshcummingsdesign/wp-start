<?php

declare(strict_types=1);

namespace WPStart\Framework\CustomFields\DataTransferObjects;

/**
 * @unreleased
 */
class Link
{
    public function __construct(
        public string $url,
        public string $text,
        /** `"_blank" | null` */
        public ?string $target,
        /** `"noopener" | null` */
        public ?string $rel,
    ) {
    }

    /**
     * Get Link from urlpicker array.
     *
     * @unreleased
     */
    public static function fromArray(?array $link): ?self
    {
        if (empty($link)) {
            return null;
        }

        return new self(
            url: $link['url'],
            text: $link['anchor'],
            target: $link['blank'] ? '_blank' : null,
            rel: $link['blank'] ? 'noopener' : null,
        );
    }

    /**
     * Get an empty instance.
     *
     * @unreleased
     */
    public static function empty(): self
    {
        return new self(
            url: '',
            text: '',
            target: null,
            rel: null,
        );
    }
}
