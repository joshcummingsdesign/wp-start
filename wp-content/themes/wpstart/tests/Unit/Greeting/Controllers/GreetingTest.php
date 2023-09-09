<?php

declare(strict_types=1);

namespace Tests\Unit\Greeting\Controllers;

use Tests\TestCase;
use WP_Error;
use WP_REST_Request;
use WPStart\Greeting\Controllers\Greeting;

/**
 * Test the greeting controller.
 */
final class GreetingTest extends TestCase
{
    public function testShouldHandleInvalidArguments(): void
    {
        $controller = new Greeting();

        $actual = $controller->greet(new WP_REST_Request());

        $expected = new WP_Error(
            'invalid_argument',
            ['name' => 'name is required'],
            ['status' => 400]
        );

        self::assertEquals($expected, $actual);
    }

    public function testShouldReturnGreeting(): void
    {
        $controller = new Greeting();

        $request = new WP_REST_Request();
        $request->set_param('name', 'William');

        $actual = $controller->greet($request);

        self::assertEquals('Hello William', $actual);
    }
}
