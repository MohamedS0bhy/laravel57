<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => env('SES_REGION', 'us-east-1'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'facebook' => [
        'client_id' => env('FACEBOOK_CLIENT_ID' , '536120023518452'),         // Your facebook Client ID
        'client_secret' => env('FACEBOOK_CLIENT_SECRET' , 'cd36722b7d4bd51f37590fb3c520ca58'), // Your facebook Client Secret
        'redirect' => 'https://laravel57.herokuapp.com/auth/facebook/callback',
        ],

    'twitter' => [
        'client_id' => env('TWITTER_CLIENT_ID' , 'jUaEK0gqT9vkmnFeoI29NQ0Fs'),         // Your twitter Client ID
        'client_secret' => env('TWITTER_CLIENT_SECRET' , 'YSwJhWZoAANATX2xY17h6Ln6iKO17GyyWeQlYFwkr6dcUrcpum'), // Your twitter Client Secret
        'redirect' => 'https://laravel57.herokuapp.com/auth/twitter/callback',
        ],

    'google' => [
        'client_id'     => env('GOOGLE_CLIENT_ID' ,'331479771764-vfbfbrc9joj21at2n54n3nl9dbsnbuor.apps.googleusercontent.com'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET' , '8k_GEZlqhWAwhsydpue6sQHR'),
        'redirect'      => 'https://laravel57.herokuapp.com/auth/google/callback'
    ],
];
