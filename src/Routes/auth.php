<?php
Route::prefix('_goto')->group(function () {

    Route::get('/authenticate', function () {
        try {
            dd('x');
            return Webinars::authenticate();//->status();
        } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {
            return [$e->getMessage()];
        }
    })->name('goto.auth');

    Route::get('/callback', function (Request $request) {
        try {
            if(Webinars::handleAuthorizationCallback($request)){
                return ['authenticated'];
            };

            return ['not authenticated'];
        } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {
            return [$e->getMessage()];
        }
    })->name('goto.callback');

    Route::get('/flush-auth', function () {
        try {
            return Webinars::flushAuthentication()->status();
        } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {
            return [$e->getMessage()];
        }
    })->name('goto.flush');

});
