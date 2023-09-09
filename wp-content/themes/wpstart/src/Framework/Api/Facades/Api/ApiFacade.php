<?php

declare(strict_types=1);

namespace WPStart\Framework\Api\Facades\Api;

use WPStart\Framework\Api\Response;

/**
 * Api facade.
 *
 * @unreleased
 */
class ApiFacade
{
    /**
     * Send or return data.
     *
     * @unreleased
     *
     * @return Response|void
     */
    public function send(Response $response, bool $shouldReturn = false)
    {
        if ($shouldReturn) {
            return $response;
        }

        wp_send_json($response);
    }
}
