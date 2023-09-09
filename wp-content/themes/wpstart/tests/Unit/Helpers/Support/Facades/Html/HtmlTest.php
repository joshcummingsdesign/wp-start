<?php

declare(strict_types=1);

namespace Tests\Unit\Helpers\Support\Facades\Html;

use Tests\TestCase;
use WPStart\Helpers\Support\Facades\Html\DataTransferObjects\HeadingListItem;
use WPStart\Helpers\Support\Facades\Html\Html;

/**
 * Test the Html facade.
 */
final class HtmlTest extends TestCase
{
    public function testShouldFilterHtml(): void
    {
        $content = '
            <div class="post-wrapper">
                <div class="posts">
                    <div class="post">
                        <p class="title">One</p>
                        <div class="categories">
                            <a class="category">One</a>
                            <a class="category">Two</a>
                            <a class="info">
                                <span class="info_text"></span>
                            </a>
                            <a class="info">
                                <span class="info_text"></span>
                            </a>
                        </div>
                    </div>
                    <div class="post">
                        <p class="title">Two</p>
                        <div class="categories">
                            <a class="category">One</a>
                            <a class="category">Two</a>
                            <a class="info">
                                <span class="info_text"></span>
                            </a>
                            <a class="info">
                                <span class="info_text"></span>
                            </a>
                        </div>
                    </div>
                    <div class="post">
                        <p class="title">Three</p>
                        <div class="categories">
                            <a class="category">One</a>
                            <a class="category">Two</a>
                            <a class="info">
                                <span class="info_text"></span>
                            </a>
                            <a class="info">
                                <span class="info_text"></span>
                            </a>
                        </div>
                    </div>
                </div>
                <a class="link">Foobar</a>
                <div class="wrapper">
                    <a class="button">Foo</a>
                </div>
            </div>
        ';

        $expected = '
            <div class="post-wrapper">
                <div class="posts">
                    <div class="post">
                        <p class="title new-class">Post 1</p>
                        <div class="categories">
                            <a class="category">Cat 1</a>
                            <a class="category">Cat 2</a>
                            <a class="info" href="#">
                                <span class="info_text">Info 1</span>
                            </a>
                            <a class="info" href="#">
                                <span class="info_text">Info 2</span>
                            </a>
                        </div>
                    </div>
                    <div class="post">
                        <p class="title">Post 2</p>
                        <div class="categories">
                            <a class="category">Cat 3</a>
                            <a class="category">Cat 4</a>
                            <a class="info" href="#">
                                <span class="info_text">Info 3</span>
                            </a>
                            <a class="info" href="#">
                                <span class="info_text">Info 4</span>
                            </a>
                        </div>
                    </div>
                    <div class="post">
                        <p class="title">Post 3</p>
                        <div class="categories">
                            <a class="category">Cat 5</a>
                            <a class="category">Cat 6</a>
                            <a class="info" href="#">
                                <span class="info_text">Info 5</span>
                            </a>
                            <a class="info" href="#">
                                <span class="info_text">Info 6</span>
                            </a>
                        </div>
                    </div>
                </div>
                <a class="link" href="/test-link">This is a link</a>
                <div class="wrapper">
                    <a class="button" href="#">Bar</a>
                </div>
            </div>
        ';

        $actual = Html::filter([
            '.post' => [
                [
                    '.title' => [
                        'html' => 'Post 1',
                        'className' => 'new-class',
                    ],
                    '.category' => [
                        [
                            'html' => 'Cat 1',
                        ],
                        [
                            'html' => 'Cat 2',
                        ],
                    ],
                    '.info' => [
                        [
                            'href' => '#',
                            '.info_text' => [
                                'html' => 'Info 1',
                            ],
                        ],
                        [
                            'href' => '#',
                            '.info_text' => [
                                'html' => 'Info 2',
                            ],
                        ],
                    ],
                ],
                [
                    '.title' => [
                        'html' => 'Post 2',
                    ],
                    '.category' => [
                        [
                            'html' => 'Cat 3',
                        ],
                        [
                            'html' => 'Cat 4',
                        ],
                    ],
                    '.info' => [
                        [
                            'href' => '#',
                            '.info_text' => [
                                'html' => 'Info 3',
                            ],
                        ],
                        [
                            'href' => '#',
                            '.info_text' => [
                                'html' => 'Info 4',
                            ],
                        ],
                    ],
                ],
                [
                    '.title' => [
                        'html' => 'Post 3',
                    ],
                    '.category' => [
                        [
                            'html' => 'Cat 5',
                        ],
                        [
                            'html' => 'Cat 6',
                        ],
                    ],
                    '.info' => [
                        [
                            'href' => '#',
                            '.info_text' => [
                                'html' => 'Info 5',
                            ],
                        ],
                        [
                            'href' => '#',
                            '.info_text' => [
                                'html' => 'Info 6',
                            ],
                        ],
                    ],
                ],
            ],
            '.link' => [
                'html' => 'This is a link',
                'href' => '/test-link',
            ],
            '.wrapper' => [
                '.button' => [
                    'html' => 'Bar',
                    'href' => '#',
                ],
            ],
        ], $content);

        self::assertEquals(trim($expected), trim($actual));
    }

    public function testShouldGetHeadings(): void
    {
        $content = '
            <div class="post-wrapper">
                <h2 class="wp-block-heading">Heading 1</h2>
                <p>Lorem ipsum...</p>
                <h2 class="wp-block-heading">Heading 2</h2>
                <h3 class="wp-block-heading">Subheading 1</h3>
                <p>Lorem ipsum...</p>
                <h2 class="wp-block-heading">Heading 3</h2>
                <h3 class="wp-block-heading">Subheading 2</h3>
                <p>Lorem ipsum...</p>
                <h2 class="wp-block-heading">Heading 4</h2>
                <p>Lorem ipsum...</p>
            </div>
        ';

        $expected = [
            new HeadingListItem(
                title: 'Heading 1',
                slug: 'h-heading-1',
                number: '1.',
                children: [],
            ),
            new HeadingListItem(
                title: 'Heading 2',
                slug: 'h-heading-2',
                number: '2.',
                children: [
                    new HeadingListItem(
                        title: 'Subheading 1',
                        slug: 'h-subheading-1',
                        number: '2.1',
                        children: [],
                    ),
                ],
            ),
            new HeadingListItem(
                title: 'Heading 3',
                slug: 'h-heading-3',
                number: '3.',
                children: [
                    new HeadingListItem(
                        title: 'Subheading 2',
                        slug: 'h-subheading-2',
                        number: '3.1',
                        children: [],
                    ),
                ],
            ),
            new HeadingListItem(
                title: 'Heading 4',
                slug: 'h-heading-4',
                number: '4.',
                children: [],
            ),
        ];

        self::assertEquals($expected, Html::getHeadings($content));
    }
}
