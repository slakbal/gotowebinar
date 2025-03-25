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