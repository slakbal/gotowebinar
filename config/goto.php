<?php

return [

    //https://developer.goto.com/guides/References/05_Direct-Login_migration/
    //IMPORTANT: New OAuth clients created on the Goto site will not work with a password grant flow.
    //Any client with the password grant enabled will continue to work for the known future.
    
    'auth_grant_flow_type' => env('GOTO_AUTH_GRANT_FLOW_TYPE', 'password'), //'authorization' or 'password' --> Password Grant Flow or Authorization Code Grant Flow

    'client_id' => env('GOTO_CONSUMER_KEY', 'someConsumerKey'),
    'client_secret' => env('GOTO_CONSUMER_SECRET', 'someConsumerSecret'),
    'redirect_uri' => env('GOTO_REDIRECT_URI', 'http://your-app.com/goto/callback'),

    'direct_username' => env('GOTO_DIRECT_USERNAME', null),
    'direct_password' => env('GOTO_DIRECT_PASSWORD', null),

    'subject_suffix' => env('GOTO_SUBJECT_SUFFIX', null),
    'webinar_link' => env('GOTO_WEBINAR_LINK', 'https://global.gotowebinar.com/manageWebinar.tmpl?webinar=%s'),
];
