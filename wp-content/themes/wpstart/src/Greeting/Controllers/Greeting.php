<?php

declare(strict_types=1);

namespace WPStart\Greeting\Controllers;

use WP_Error;
use WP_REST_Request;
use WPStart\Vendor\StellarWP\Validation\Validator;

/**
 * The greeting controller.
 *
 * @unreleased
 */
class Greeting
{
    /**
     * Greet the user.
     *
     * @unreleased
     *
     * @param WP_REST_Request $request
     *
     * @type string           $name
     */
    public function greet(WP_REST_Request $request): string|WP_Error
    {
        $requestData = [
            'name' => sanitize_text_field($request['name']),
        ];

        $validator = new Validator([
            'name' => ['required'],
        ], $requestData);

        if ($validator->passes()) {
            $validated = $validator->validated();
        } else {
            return new WP_Error(
                'invalid_argument',
                $validator->errors(),
                ['status' => 400]
            );
        }

        return "Hello " . $validated['name'];
    }
}
