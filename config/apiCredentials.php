<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Mojagate API creds
    |--------------------------------------------------------------------------
    |
    */
    'mojagate_sms_service' => [
        'email' => env('email', 'null'),
        'password' => env('password', 'null'),
    ],

    'safaricom_payment_service' => [
        'consumer_key' => env('consumer_key', 'null'),
        'consumer_secret' => env('consumer_secret', 'null'),
        'passkey' => env('passkey', 'null'),
    ],
];