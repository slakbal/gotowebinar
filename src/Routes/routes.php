<?php

//explicitly apply the web group middleware so that the session is started for the provider
Route::prefix('_goto')->middleware(['web'])->group(function () {

    Route::any('/redirect', function (Request $request) {

        Log::alert('*********** '.Request::input('code'). ' ***************');

    })->name('goto.redirect');

    Route::get('/url', function (Request $request) {

        $parameters = [
            'client_id' => config('goto.client_id'),
            'response_type' => 'code',
            'redirect_uri' => route('goto.redirect')
        ];

        return ['https://api.getgo.com/oauth/v2/authorize?' . http_build_query($parameters)];
    })->name('goto.url');

    require_once __DIR__ . '/state.php';
    require_once __DIR__ . '/webinars.php';
    require_once __DIR__ . '/registrants.php';
    require_once __DIR__ . '/sessions.php';
    require_once __DIR__ . '/objects.php';
});