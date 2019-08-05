<?php

Route::get('/ping', function () {
    return response()->json(["result" => 'ping'], 200);
})->name('goto.ping');


Route::get('/', function () {

    try {

        $gotoResponse = GotoWebinar::state();
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {

        return [$e->getMessage()];
    }

    return [$gotoResponse];
})->name('goto.state');


Route::get('/reauth', function () {

    try {

        $gotoResponse = GotoWebinar::reauthenticate();
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {

        return [$e->getMessage()];
    }

    return [$gotoResponse];
})->name('goto.refresh');


Route::get('/oauth2', function () {

    try {

        $response = GotoWebinar::getAuthorizationCode();

    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {

        return [$e->getMessage()];
    }

    return redirect($response->headers['location']);
})->name('goto.refresh');