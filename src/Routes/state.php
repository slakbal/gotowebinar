<?php

Route::get('/ping', function () {
    return response()->json(['result' => 'I\'m here'], 200);
})->name('goto.ping');

Route::get('/', function () {
    return Webinars::status();
})->name('goto.status');

Route::get('/authenticate', function () {
    return Webinars::authenticate()->status();
})->name('goto.auth');

Route::get('/flush-auth', function () {
    return Webinars::flushAuthentication()->status();
})->name('goto.flush');
