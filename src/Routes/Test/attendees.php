<?php

use Slakbal\Gotowebinar\Exceptions\RequiresReAuthorizationException;
use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\GotoApi;

Route::prefix('webinars')->name('goto.')
    ->group(function () {

        $gotoApi = new GotoApi;

        Route::get('/{webinarKey}/sessions/{sessionKey}/attendees', function ($webinarKey, $sessionKey) use ($gotoApi) {
            try {
                return $gotoApi->attendees()->all(
                    sessionKey: $sessionKey,
                    webinarKey: $webinarKey,
                    organizerKey: null,
                )->json();
            } catch (RequiresReAuthorizationException $e) {
                return redirect()->route('goto.authorize');
            }
        });

        Route::get('/{webinarKey}/sessions/{sessionKey}/attendees/{registrantKey}/polls', function ($webinarKey, $sessionKey, $registrantKey) use ($gotoApi) {
            try {
                return $gotoApi->attendees()->polls(
                    sessionKey: $sessionKey,
                    registrantKey: $registrantKey,
                    webinarKey: $webinarKey,
                    organizerKey: null
                )->json();
            } catch (RequiresReAuthorizationException $e) {
                return redirect()->route('goto.authorize');
            }
        });

        Route::get('/{webinarKey}/sessions/{sessionKey}/attendees/{registrantKey}', function ($webinarKey, $sessionKey, $registrantKey) use ($gotoApi) {
            try {
                return $gotoApi->attendees()->get(
                    sessionKey: $sessionKey,
                    registrantKey: $registrantKey,
                    webinarKey: $webinarKey,
                    organizerKey: null
                )->json();
            } catch (RequiresReAuthorizationException $e) {
                return redirect()->route('goto.authorize');
            }
        });

    });
