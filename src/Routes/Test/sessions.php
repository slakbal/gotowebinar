<?php

use Slakbal\Gotowebinar\Exceptions\RequiresReAuthorizationException;
use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\GotoApi;

Route::prefix('webinars')->name('goto.')
    ->group(function () {

        $gotoApi = new GotoApi;

        Route::get('/{webinarKey}/sessions', function ($webinarKey) use ($gotoApi) {
            try {
                $response = $gotoApi->sessions()->all(
                    webinarKey: $webinarKey,
                    organizerKey: null,
                    page: 0, //max is 200
                    limit: 10
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

        Route::get('/{webinarKey}/sessions/{sessionKey}/cancel', function ($webinarKey, $sessionKey) use ($gotoApi) {
            try {
                $response = $gotoApi->sessions()->delete(
                    webinarKey: $webinarKey,
                    sessionKey: $sessionKey,
                    organizerKey: null
                );

                if ($response->successful()) {
                    return [true];
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
