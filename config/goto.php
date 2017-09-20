<?php

return [

    //what authentication method to use 'direct', 'oauth2'. Currently only support 'direct'
    'auth_type' => 'direct',

    'default_locale' => 'de_DE', //en_US

    'direct' => [
        'username'  => env('GOTO_DIRECT_USER', 'user.account@test.com'),
        'password'  => env('GOTO_CONSUMER_SECRET', 'someSecret'),
        'client_id' => env('GOTO_CONSUMER_KEY', 'someConsumerKey'),
    ],

];