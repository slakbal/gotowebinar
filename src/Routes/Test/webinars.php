<?php

use Carbon\CarbonImmutable;
use Slakbal\Gotowebinar\Exceptions\RequiresReAuthorizationException;
use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\GotoApi;

Route::prefix('webinars')->name('goto.webinars')
    ->group(function () {

        $gotoApi = new GotoApi;

        Route::get('/', function () use ($gotoApi) {
            try {
                return $gotoApi->webinars()->all(
                    fromTime: CarbonImmutable::now()->subMonths(24),
                    toTime: CarbonImmutable::now(),
                    page: 0,
                    size: 20
                )->json('_embedded.webinars'); //select the json node to return
            } catch (RequiresReAuthorizationException $e) {
                return redirect()->route('goto.authorize');
            }
        });

        Route::get('create', function () use ($gotoApi) {
            try {

                //Make use of the DTO to create a webinar since it ensures data integrity
                $webinarDto = new \Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Dtos\CreateWebinarDto(
                    subject: 'Test Subject',
                    startTime: \Carbon\CarbonImmutable::now()->addDay(1),
                    endTime: \Carbon\CarbonImmutable::now()->addDay(1)->addHours(1),
                    description: 'Test Description',
                    type: \Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Enums\WebinarType::SINGLE_SESSION, //optional: default: single_session
                    experienceType: \Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Enums\WebinarExperience::CLASSIC //optional: default: CLASSIC
                );

                return $gotoApi->webinars()->create($webinarDto)->json();
            } catch (RequiresReAuthorizationException $e) {
                return redirect()->route('goto.authorize');
            }
        });


        Route::get('in-session', function () use ($gotoApi) {
            try {
                return $gotoApi->webinars()->inSession(
                    toTime: CarbonImmutable::now(),
                //fromTime: CarbonImmutable::now()->subHours(2),
                )->json(); //select the json node to return
            } catch (RequiresReAuthorizationException $e) {
                return redirect()->route('goto.authorize');
            }
        });

        Route::get('{webinarKey}', function ($webinarKey) use ($gotoApi) {
            try {
                $response = $gotoApi->webinars()->get(
                    webinarKey: $webinarKey
                );

                if ($response->successful()) {
                    return $response->json();
                }

                if ($response->failed()) {
                    return $response->json();
                }

                return [$response->status()];

            } catch (RequiresReAuthorizationException $e) {
                return redirect()->route('goto.authorize');
            }
        });

        Route::get('{webinarKey}/cancel', function ($webinarKey) use ($gotoApi) {
            try {
                $response = $gotoApi->webinars()->cancel(
                    webinarkey: $webinarKey,
                    sendCancellationEmails: true
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

        Route::get('{webinarKey}/meeting-times', function ($webinarKey) use ($gotoApi) {
            try {
                $response = $gotoApi->webinars()->meetingTimes(
                    webinarKey: $webinarKey
                );

                //Example of how response states can be used to control code
                if ($response->successful()) {
                    return $response->json();
                }

                if ($response->failed()) {
                    return $response->json();
                }

                return [$response->status()];

            } catch (RequiresReAuthorizationException $e) {
                return redirect()->route('goto.authorize');
            }
        });

        Route::get('{webinarKey}/attendees', function ($webinarKey) use ($gotoApi) {
            try {
                $response = $gotoApi->webinars()->attendees(
                    webinarKey: $webinarKey,
                    page: 0,
                    size: 50
                );

                //Example of how response states can be used to control code
                if ($response->successful()) {
                    return $response->json('_embedded.attendeeParticipationResponses');
                }

                if ($response->failed()) {
                    return $response->json();
                }

                return [$response->status()];

            } catch (RequiresReAuthorizationException $e) {
                return redirect()->route('goto.authorize');
            }
        });


        Route::get('{webinarKey}/audio', function ($webinarKey) use ($gotoApi) {
            try {
                $response = $gotoApi->webinars()->audio(
                    webinarKey: $webinarKey
                );

                //Example of how response states can be used to control code
                if ($response->successful()) {
                    return $response->json();
                }

                if ($response->failed()) {
                    return $response->json();
                }

                return [$response->status()];

            } catch (RequiresReAuthorizationException $e) {
                return redirect()->route('goto.authorize');
            }
        });

        Route::get('{webinarKey}/performance', function ($webinarKey) use ($gotoApi) {
            try {
                $response = $gotoApi->webinars()->performance(
                    webinarKey: $webinarKey
                );

                //Example of how response states can be used to control code
                if ($response->successful()) {
                    return $response->json();
                }

                if ($response->failed()) {
                    return $response->json();
                }

                return [$response->status()];

            } catch (RequiresReAuthorizationException $e) {
                return redirect()->route('goto.authorize');
            }
        });

        Route::get('{webinarKey}/start-url', function ($webinarKey) use ($gotoApi) {
            try {
                $response = $gotoApi->webinars()->startUrl(
                    webinarKey: $webinarKey
                );

                //Example of how response states can be used to control code
                if ($response->successful()) {
                    return $response->json();
                }

                if ($response->failed()) {
                    return $response->json();
                }

                return [$response->status()];

            } catch (RequiresReAuthorizationException $e) {
                return redirect()->route('goto.authorize');
            }
        });

        Route::get('{webinarKey}/recording-assets', function ($webinarKey) use ($gotoApi) {
            try {
                $response = $gotoApi->webinars()->recordingAssets(
                    webinarKey: $webinarKey,
                    page: 0,
                    limit: 20
                );

                //Example of how response states can be used to control code
                if ($response->successful()) {
                    return $response->json('data');
                }

                if ($response->failed()) {
                    return $response->json();
                }

                return [$response->status()];

            } catch (RequiresReAuthorizationException $e) {
                return redirect()->route('goto.authorize');
            }
        });

    });
