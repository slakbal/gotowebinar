<?php

use Slakbal\Gotowebinar\Exceptions\RequiresReAuthorizationException;
use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\GotoApi;

Route::prefix('webinars')->name('goto.')
    ->group(function () {

        $gotoApi = new GotoApi;

        Route::get('/{webinarKey}/sessions', function ($webinarKey) use ($gotoApi) {
            try {
                // https://docs.saloon.dev/installable-plugins/pagination#using-laravel-collections-lazycollection
                // https://laravel.com/docs/11.x/collections

                // returns LazyCollection as such can also call ->toArray() on the response and use Laravel collection methods
                return $gotoApi->sessions()->all(
                    webinarKey: $webinarKey,
                    requestPageLimit: 200, //default max is 200 as per API spec. Ie. if set to 100 and there are 200 records to retrieve it will take 2 requests to fetch all.
                    organizerKey: null
                );

            } catch (RequiresReAuthorizationException $e) {
                return redirect()->route('goto.authorize');
            }
        });

        Route::get('/{webinarKey}/sessions/{sessionKey}', function ($webinarKey, $sessionKey) use ($gotoApi) {
            try {
                $response = $gotoApi->sessions()->get(
                    webinarKey: $webinarKey,
                    sessionKey: $sessionKey,
                    organizerKey: null,
                );

                if ($response->successful()) {
                    return $response->json();
                }

                if ($response->failed()) {
                    return $response->json();
                }

                return $response->json();

            } catch (RequiresReAuthorizationException $e) {
                return redirect()->route('goto.authorize');
            }
        });

        Route::get('/{webinarKey}/sessions/{sessionKey}/performance', function ($webinarKey, $sessionKey) use ($gotoApi) {
            try {
                $response = $gotoApi->sessions()->performance(
                    webinarKey: $webinarKey,
                    sessionKey: $sessionKey,
                    organizerKey: null
                );

                if ($response->successful()) {
                    return $response->json();
                }

                if ($response->failed()) {
                    return $response->json();
                }

                return $response->json();
            } catch (RequiresReAuthorizationException $e) {
                return redirect()->route('goto.authorize');
            }
        });

        Route::get('/{webinarKey}/sessions/{sessionKey}/polls', function ($webinarKey, $sessionKey) use ($gotoApi) {
            try {
                $response = $gotoApi->sessions()->polls(
                    webinarKey: $webinarKey,
                    sessionKey: $sessionKey,
                    organizerKey: null
                );

                if ($response->successful()) {
                    return $response->json();
                }

                if ($response->failed()) {
                    return $response->json();
                }

                return $response->json();
            } catch (RequiresReAuthorizationException $e) {
                return redirect()->route('goto.authorize');
            }
        });

        Route::get('/{webinarKey}/sessions/{sessionKey}/questions', function ($webinarKey, $sessionKey) use ($gotoApi) {
            try {
                $response = $gotoApi->sessions()->questions(
                    webinarKey: $webinarKey,
                    sessionKey: $sessionKey,
                    organizerKey: null
                );

                if ($response->successful()) {
                    return $response->json();
                }

                if ($response->failed()) {
                    return $response->json();
                }

                return $response->json();
            } catch (RequiresReAuthorizationException $e) {
                return redirect()->route('goto.authorize');
            }
        });

        Route::get('/{webinarKey}/sessions/{sessionKey}/surveys', function ($webinarKey, $sessionKey) use ($gotoApi) {
            try {
                $response = $gotoApi->sessions()->surveys(
                    webinarKey: $webinarKey,
                    sessionKey: $sessionKey,
                    organizerKey: null
                );

                if ($response->successful()) {
                    return $response->json();
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
