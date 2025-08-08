<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    // eSewa Payment configuration
    'esewa' => [
        // Merchant/product code provided by eSewa (for RC/UAT use EPAYTEST unless you have a dedicated code)
        'product_code' => env('ESEWA_PRODUCT_CODE', 'EPAYTEST'),
        // Secret key to sign the request fields (provided by eSewa RC/UAT)
        'secret_key' => env('ESEWA_SECRET_KEY', ''),
        // Base endpoint (RC/UAT)
        'form_url' => env('ESEWA_FORM_URL', 'https://rc-epay.esewa.com.np/api/epay/main/v2/form'),
        // Success/Failure URLs are generated dynamically via routes
        // Signed fields to include in signature. eSewa commonly requires these 3.
        'signed_fields' => env('ESEWA_SIGNED_FIELDS', 'total_amount,transaction_uuid,product_code'),
    ],

];
