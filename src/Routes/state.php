<?php

Route::get('/ping', function () {
    return response()->json(["result" => 'Hallo Goto'], 200);
})->name('goto.ping');

Route::get('/', function () {

    return \Slakbal\Gotowebinar\Facade\Webinars::status();
})->name('goto.status');

Route::get('/authenticate', function () {

    return \Slakbal\Gotowebinar\Facade\Webinars::authenticate()->status();
})->name('goto.auth');

Route::get('/flush-auth', function () {

    return \Slakbal\Gotowebinar\Facade\Webinars::flushAuthentication()->status();
})->name('goto.flush');


/*

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
*/