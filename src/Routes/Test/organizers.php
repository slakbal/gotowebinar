<?php

use Slakbal\Gotowebinar\Exceptions\RequiresReAuthorizationException;
use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\GotoApi;

Route::prefix('organizers')->name('goto.')
    ->group(function () {

        $gotoApi = new GotoApi;

        Route::get('/sessions', function () use ($gotoApi) {
            try {
                $response = $gotoApi->sessions()->organizerSessions(
                    fromTime: \Carbon\CarbonImmutable::now()->startOfDay()->subMonths(24),
                    toTime: \Carbon\CarbonImmutable::now()->endOfDay(),
                    page: 0, //max is 200
                    size: 10,
                    organizerKey: null,
                );

                if ($response->successful()) {
                    return $response->json('_embedded.sessionInfoResources');
                }

                if ($response->failed()) {
                    return $response->json();
                }

                return $response->json();

            } catch (RequiresReAuthorizationException $e) {
                return redirect()->route('goto.authorize');
            }
        });
    });
