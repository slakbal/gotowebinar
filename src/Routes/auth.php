<?php
Route::prefix('_goto')->group(function () {

    Route::get('/authenticate', function () {
        try {
            if(config('goto.auth_grant_flow_type') == 'password')
            {
                if(Webinars::authenticate()) {
                    return ['Authenticated on password grant flow.'];
                };

                return ['Could not Authenticate on password grant flow.'];
            }

            if(config('goto.auth_grant_flow_type') == 'authorization')
            {
                //a redirect response is sent back to complete the authentication grant flow
                return Webinars::authenticate();
            }

            return ['Invalid authentication flow type on Authentication request. Please check your configuration.'];

        } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {
            return [$e->getMessage()];
        }
    })->name('goto.auth');

    Route::get('/callback', function (Request $request) {
        try {

            if(Webinars::handleAuthorizationCallback($request)) {
                return ['Authenticated on authentication grant flow.'];
            };

            return ['Could not Authenticate on authentication grant flow.'];
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
