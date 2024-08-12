<?php

use Carbon\CarbonImmutable;
use Slakbal\Gotowebinar\Exceptions\RequiresReAuthorizationException;
use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\GotoApi;

Route::prefix('webinars')->name('goto.webinars')
    ->group(function () {

        $gotoApi = new GotoApi;

        Route::get('/', function () use ($gotoApi) {
            try {

                // https://docs.saloon.dev/installable-plugins/pagination#using-laravel-collections-lazycollection
                // https://laravel.com/docs/11.x/collections

                // returns LazyCollection as such can also call ->toArray() on the response and use Laravel collection methods
                return $gotoApi->webinars()->all(
                    fromTime: CarbonImmutable::now()->startOfDay()->subYears(4),
                    toTime: CarbonImmutable::now()->endOfDay(),
                    requestPageLimit: 200 //default max is 200 as per API spec. Ie. if set to 100 and there are 200 records to retrieve it will take 2 requests to fetch all.
                );
            } catch (RequiresReAuthorizationException $e) {
                return redirect()->route('goto.authorize');
            }
        });

        Route::get('/page/{page}/size/{pageSize}', function (int $page = 0, int $pageSize = 10) use ($gotoApi) {
            try {
                return $gotoApi->webinars()->page(
                    fromTime: CarbonImmutable::now()->startOfDay()->subMonths(24),
                    toTime: CarbonImmutable::now()->endOfDay(),
                    page: $page,
                    pageSize: $pageSize
                )->json('_embedded.webinars'); //or ->collect('_embedded.webinars') //select the json node to return, null/empty to return paginator also
            } catch (RequiresReAuthorizationException $e) {
                return redirect()->route('goto.authorize');
            }
        });

        Route::get('create', function () use ($gotoApi) {
            try {

                //Make use of the DTO to create a webinar since it ensures data integrity
                $webinarDto = new \Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Dtos\CreateWebinarDto(
                    subject: 'Test Webinar - API Integration',
                    startTime: \Carbon\CarbonImmutable::now()->addHours(1),
                    endTime: \Carbon\CarbonImmutable::now()->addHours(1)->addMinutes(10),
                    description: 'Test Description',
                    type: \Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Enums\WebinarType::SINGLE_SESSION, //optional: default: single_session
                    experienceType: \Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Enums\WebinarExperience::CLASSIC, //optional: default: CLASSIC
                    confirmationEmail: true,
                    reminderEmail: true,
                    absenteeFollowUpEmail: true,
                    attendeeFollowUpEmail: true,
                    suffix: '***',
                    attendeeIncludeCertificate: true,
                    timeZone: 'Europe/Berlin',
                    isPasswordProtected: true
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
                    // fromTime: CarbonImmutable::now()->startOfDay()->subHours(2), //it is possible to set also a fromTime
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
                    webinarKey: $webinarKey,
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

                // https://docs.saloon.dev/installable-plugins/pagination#using-laravel-collections-lazycollection
                // https://laravel.com/docs/11.x/collections

                // returns LazyCollection as such can also call ->toArray on the response
                return $gotoApi->webinars()->attendees(
                    webinarKey: $webinarKey,
                    requestPageLimit: 200 //default max is 200 as per API spec. Ie. if set to 100 and there are 200 records to retrieve it will take 2 requests to fetch all.
                );

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
                    page: null,
                    pageSize: null
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
