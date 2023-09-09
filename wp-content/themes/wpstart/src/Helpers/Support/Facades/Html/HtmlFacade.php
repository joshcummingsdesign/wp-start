<?php

declare(strict_types=1);

namespace WPStart\Helpers\Support\Facades\Html;

use DomDocument;
use DOMNodeList;
use DOMXpath;
use WPStart\Helpers\Support\Facades\Html\DataTransferObjects\HeadingListItem;
use WPStart\Helpers\Support\Facades\Str\Str;

/**
 * Html facade.
 *
 * @unreleased
 */
class HtmlFacade
{
    /**
     * Filter an HTML string.
     *
     * Given this HTML content:
     *
     * ```
     * <div class="root">
     *     <div class="posts">
     *         <div class="post">
     *             <p class="title"></p>
     *             <div class="categories">
     *                 <div class="category"></div>
     *             </div>
     *         </div>
     *         <div class="post">
     *             <p class="title"></p>
     *             <div class="categories">
     *                 <div class="category"></div>
     *             </div>
     *         </div>
     *     </div>
     *     <a class="link"></a>
     * </div>
     * ```
     *
     * Run the following:
     *
     * ```
     * Html::filter([
     *     '.post' => [
     *         [
     *             '.title' => [
     *                 'html' => 'Post 1',
     *                 'className' => 'my-class',
     *             ],
     *             '.category' => [
     *                 [
     *                     'html' => 'Category 1',
     *                 ],
     *             ],
     *         ],
     *         [
     *             '.title' => [
     *                 'html' => 'Post 2',
     *             ],
     *             '.category' => [
     *                 [
     *                     'html' => 'Category 2',
     *                 ],
     *             ],
     *         ],
     *     ],
     *     '.link' => [
     *         'html' => 'Test Link',
     *         'href' => '/test-link',
     *     ],
     * ], $content);
     * ```
     *
     * And get this output:
     *
     * ```
     * <div class="root">
     *     <div class="posts">
     *         <div class="post">
     *             <p class="title my-class">Post 1</p>
     *             <div class="categories">
     *                 <div class="category">Category 1</div>
     *             </div>
     *         </div>
     *         <div class="post">
     *             <p class="title">Post 2</p>
     *             <div class="categories">
     *                 <div class="category">Category 2</div>
     *             </div>
     *         </div>
     *     </div>
     *     <a class="link" href="/test-link">Test Link</a>
     * </div>
     * ```
     *
     * $attributes = ['html' => string, $attribute => string, ...];
     *
     * @unreleased
     *
     * @param array  $query   [$className => $attributes|$query]
     * @param string $content The HTML string to filter.
     *
     * @return string The filtered HTML string.
     */
    public function filter(
        array $query,
        string $content,
        ?int $index = null,
        ?DOMNodeList $parents = null,
        ?DOMNodeList $elements = null,
        ?DomDocument $dom = null,
        ?DOMXpath $xpath = null
    ): string {
        if ( ! isset($dom, $xpath)) {
            $dom = new DomDocument();
            @$dom->loadHTML($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            $xpath = new DOMXpath($dom);
        }

        foreach ($query as $key => $val) {
            // If the key is a className such as `.my-class`
            if (is_array($val) && is_string($key) && str_contains($key, '.')) {
                $className = str_replace('.', '', $key);

                if ($parents !== null && $index !== null) {
                    // Query $parent($index)->$className
                    $node = $xpath->query("descendant::*[contains(concat(' ', normalize-space(@class), ' '), ' $className ')]",
                        $parents->item($index));
                } elseif ($parents !== null) {
                    // Query $parent->$className
                    $node = $xpath->query("descendant::*[contains(concat(' ', normalize-space(@class), ' '), ' $className ')]",
                        $parents->item(0));
                } else {
                    // Query $className
                    $node = $xpath->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $className ')]");
                }

                $elements = $node instanceof DOMNodeList ? $node : null;

                // Nested values, iterate recursively
                $this->filter($val, $content, null, $elements, $elements, $dom, $xpath);
            } elseif (is_int($key) && is_array($val)) {
                // Nested values w/ index, iterate recursively
                $this->filter($val, $content, $key, $parents, $elements, $dom, $xpath);
            } elseif ($key === 'html') {
                // Set html
                $elements && $elements->item($index ?? 0)->nodeValue = $val;
            } elseif ($key === 'className') {
                // Add className
                $classList = $elements ? $elements->item($index ?? 0)->getAttribute('class') : '';
                $elements && $elements->item($index ?? 0)->setAttribute('class', "$classList $val");
            } else {
                // Set attribute
                $elements && $elements->item($index ?? 0)->setAttribute($key, (string)$val);
            }
        }

        return $dom->saveHTML();
    }

    /**
     * Get all the h2 and h3 headings from an HTML string.
     *
     * Headings must contain the class wp-block-heading.
     *
     * @unreleased
     *
     * @return HeadingListItem[]
     */
    public function getHeadings(string $content): array
    {
        $html = mb_convert_encoding($content, 'HTML-ENTITIES', "UTF-8");
        $dom = new DomDocument();
        @$dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $xpath = new DOMXpath($dom);
        $nodes = $xpath->query("//*[(self::h2 or self::h3) and contains(concat(' ', normalize-space(@class), ' '), ' wp-block-heading ')]");

        $headings = [];
        $h2Index = 0;
        $h3Index = 0;
        foreach ($nodes as $node) {
            if ($node->tagName === 'h3') {
                if ( ! isset($headings[$h2Index - 1])) {
                    continue;
                }

                $headings[$h2Index - 1]->children[] = new HeadingListItem(
                    title: $node->nodeValue,
                    slug: Str::slugify($node->nodeValue, 'h'),
                    number: $h2Index . '.' . ($h3Index + 1),
                    children: [],
                );

                $h3Index++;

                continue;
            }

            $headings[] = new HeadingListItem(
                title: $node->nodeValue,
                slug: Str::slugify($node->nodeValue, 'h'),
                number: ($h2Index + 1) . '.',
                children: [],
            );

            $h3Index = 0;
            $h2Index++;
        }

        return $headings;
    }
}
