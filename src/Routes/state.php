<?php

Route::get('/ping', function () {
    return response()->json(['result' => 'I\'m here'], 200);
})->name('goto.ping');

Route::get('/', function () {
    try {
        return Webinars::status();
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {
        return [$e->getMessage()];
    }
})->name('goto.status');

Route::get('/authenticate', function () {
    try {
        return Webinars::authenticate()->status();
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {
        return [$e->getMessage()];
    }
})->name('goto.auth');

Route::get('/flush-auth', function () {
    try {
        return Webinars::flushAuthentication()->status();
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {
        return [$e->getMessage()];
    }
})->name('goto.flush');
