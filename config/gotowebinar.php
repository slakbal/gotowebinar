<?php

//return [
//    'client_id' => env('GOTO_CONSUMER_KEY', 'someConsumerKey'),
//    'client_secret' => env('GOTO_CONSUMER_SECRET', 'someConsumerSecret'),
//    'direct_username' => env('GOTO_DIRECT_USERNAME', 'someUsername'),
//    'direct_password' => env('GOTO_DIRECT_PASSWORD', 'somePassword'),
//
//    'subject_suffix' => env('GOTO_SUBJECT_SUFFIX', null),
//    'webinar_link' => env('GOTO_WEBINAR_LINK', 'https://global.gotowebinar.com/manageWebinar.tmpl?webinar=%s'),
//];

return [
    'client_id' => env('GOTO_CLIENT_ID', 'someClientId'),
    'client_secret' => env('GOTO_CLIENT_SECRET', 'someClientSecret'),

    'settings_path' => storage_path('app/integrations/gotowebinar').'/gotowebinar.json',

    //    'subject_suffix' => env('GOTO_SUBJECT_SUFFIX', null),
    //    'webinar_link' => env('GOTO_WEBINAR_LINK', 'https://global.gotowebinar.com/manageWebinar.tmpl?webinar=%s'),
];
