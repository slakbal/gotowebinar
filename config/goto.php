<?php

return [
    'client_id' => env('GOTO_CONSUMER_KEY', 'someConsumerKey'),
    'client_secret' => env('GOTO_CONSUMER_SECRET', 'someConsumerSecret'),
    'redirect_uri' => env('GOTO_REDIRECT_URI', 'http://your-app.com/goto/callback'),

    'direct_username' => env('GOTO_DIRECT_USERNAME', 'someUsername'),
    'direct_password' => env('GOTO_DIRECT_PASSWORD', 'somePassword'),

    'subject_suffix' => env('GOTO_SUBJECT_SUFFIX', null),
    'webinar_link' => env('GOTO_WEBINAR_LINK', 'https://global.gotowebinar.com/manageWebinar.tmpl?webinar=%s'),
];
