<?php

Route::get('/ping', function () {
    return response()->json(["result" => 'Hallo Goto'], 200);
})->name('goto.ping');

Route::get('/', function () {

    try {
        $gotoResponse = GotoWebinar::status();
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {
        return [$e->getMessage()];
    }

    return [$gotoResponse];
})->name('goto.status');

Route::get('/authenticate', function () {

    try {
        $gotoResponse = GotoWebinar::authenticate()->status();
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {
        return [$e->getMessage()];
    }

    return [$gotoResponse];
})->name('goto.auth');

Route::get('/flush-auth', function () {

    try {
        $gotoResponse = GotoWebinar::flushAuthentication()->status();
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {
        return [$e->getMessage()];
    }

    return [$gotoResponse];
})->name('goto.flush');