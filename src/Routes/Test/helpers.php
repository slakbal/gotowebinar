<?php

use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\GotoApi;

Route::prefix('helpers')->name('goto.')
    ->group(function () {

        $gotoApi = new GotoApi;

        Route::get('flush-cache', function () use ($gotoApi) {
            // Will flush the Goto Cache completely and require a re-authorization
            // to get a new Authenticator. This could be a button action on the application side
            // to manually clear the cached values
            return [$gotoApi->flushCache()];
        })->name('flushCache');

        Route::get('status', function () use ($gotoApi) {
            // Status return true when ready to interact with the API, otherwise will
            // throw MissingAuthorizationException or MissingAuthenticatorException exception which can be handled on
            // the application side.
            return [$gotoApi->status() ? 'Ready to interact with API' : 'Not Ready'];
        })->name('status');

    });
