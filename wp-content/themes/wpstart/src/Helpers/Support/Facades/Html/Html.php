<?php

declare(strict_types=1);

namespace WPStart\Helpers\Support\Facades\Html;

use DOMDocument;
use DOMNodeList;
use DOMXPath;
use WPStart\Framework\Facades\Facade;

/**
 * Html facade.
 *
 * @unreleased
 *
 * @method static string filter(array $query, string $content, ?DOMNodeList $elements = null, ?int $index = null, ?DomDocument $dom = null, ?DOMXpath $xpath = null)
 * @method static array getHeadings(string $content) Returns: HeadingListItem[]
 */
class Html extends Facade
{
    /**
     * {@inheritDoc}
     *
     * @unreleased
     */
    protected function getFacadeAccessor(): string
    {
        return HtmlFacade::class;
    }
}
