<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Mojagate API creds
    |--------------------------------------------------------------------------
    |
    */
    'mojagate_sms_service' => [
        'api_key' => env('email', 'null'),
        'username' => env('password', 'null'),
    ],

    'safaricom_payment_service' => [
        'api_key' => env('consumer_key', 'null'),
        'username' => env('consumer_secret', 'null'),
    ],
]