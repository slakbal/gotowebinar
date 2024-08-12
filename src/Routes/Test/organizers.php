<?php

use Slakbal\Gotowebinar\Exceptions\RequiresReAuthorizationException;
use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\GotoApi;

Route::prefix('organizers')->name('goto.')
    ->group(function () {

        $gotoApi = new GotoApi;

        Route::get('/sessions', function () use ($gotoApi) {
            try {

                // https://docs.saloon.dev/installable-plugins/pagination#using-laravel-collections-lazycollection
                // https://laravel.com/docs/11.x/collections

                // returns LazyCollection as such can also call ->toArray() on the response and use Laravel collection methods
                return $gotoApi->sessions()->organizerSessions(
                    fromTime: \Carbon\CarbonImmutable::now()->startOfDay()->subMonths(24),
                    toTime: \Carbon\CarbonImmutable::now()->endOfDay(),
                    requestPageLimit: 200, //default max is 200 as per API spec. Ie. if set to 100 and there are 200 records to retrieve it will take 2 requests to fetch all.
                    organizerKey: null
                );

            } catch (RequiresReAuthorizationException $e) {
                return redirect()->route('goto.authorize');
            }
        });
    });
