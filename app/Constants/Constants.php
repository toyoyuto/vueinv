<?php

namespace App\Constants;

class Constants
{
    // サーバーステータス
    public const SERVER_STATES = [
        'ok' => 200,
        'created' => 201,
        'accepted' => 202,
        'non-authoritative' => 203,
        'badrequest' => 400,
        'unauthorized' => 401,
        'not_found' => 404,
        'unprocessable' => 422,
        'locked' => 423,
        'custom_error' => 431,
        'server_error' => 500
    ];

    public const AccountFlag = [
        'unpaid' => 0,
        'paid' => 1,
    ];
}