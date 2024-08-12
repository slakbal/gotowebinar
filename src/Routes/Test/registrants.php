<?php

use Slakbal\Gotowebinar\Exceptions\RequiresReAuthorizationException;
use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\GotoApi;

Route::prefix('webinars')->name('goto.')
    ->group(function () {

        $gotoApi = new GotoApi;

        Route::get('/{webinarKey}/registrants', function ($webinarKey) use ($gotoApi) {
            try {
                return $gotoApi->registrants()->all(
                    webinarKey: $webinarKey,
                    organizerKey: null
                )->json(); //->collect();
            } catch (RequiresReAuthorizationException $e) {
                return redirect()->route('goto.authorize');
            }
        });

        Route::get('/{webinarKey}/registrants/page/{page}/size/{pageSize}', function ($webinarKey, int $page, int $pageSize) use ($gotoApi) {
            try {
                return $gotoApi->registrants()->page(
                    webinarKey: $webinarKey,
                    page: $page,
                    pageSize: $pageSize
                )->collect('data'); //->json('data'); //select the json node to return, null/empty to return paginator also
            } catch (RequiresReAuthorizationException $e) {
                return redirect()->route('goto.authorize');
            }
        });

        Route::get('/{webinarKey}/registrants/create', function ($webinarKey) use ($gotoApi) {

            //Make use of the DTO to create a webinar since it ensures data integrity
            $registrantDto = new \Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Dtos\CreateRegistrantDto(
                firstName: 'Jack',
                lastName: 'Sparrow',
                email: 'jack.sparrow@gmail.com',
                organization: 'Test Organisation',
            );

            try {
                return $gotoApi->registrants()->create(
                    registrantDto: $registrantDto,
                    webinarKey: $webinarKey,
                    resendConfirmation: true,
                    organizerKey: null
                )->json();
            } catch (RequiresReAuthorizationException $e) {
                return redirect()->route('goto.authorize');
            }
        });

        Route::get('/{webinarKey}/registrants/fields', function ($webinarKey) use ($gotoApi) {
            try {
                return $gotoApi->registrants()->fields(
                    webinarKey: $webinarKey,
                    organizerKey: null
                )->json();
            } catch (RequiresReAuthorizationException $e) {
                return redirect()->route('goto.authorize');
            }
        });

        Route::get('/{webinarKey}/registrants/{registrantKey}', function ($webinarKey, $registrantKey) use ($gotoApi) {
            try {
                return $gotoApi->registrants()->get(
                    registrantKey: $registrantKey,
                    webinarKey: $webinarKey,
                    organizerKey: null
                )->json();
            } catch (RequiresReAuthorizationException $e) {
                return redirect()->route('goto.authorize');
            }
        });

        Route::get('/{webinarKey}/registrants/{registrantKey}/cancel', function ($webinarKey, $registrantKey) use ($gotoApi) {
            try {
                $response = $gotoApi->registrants()->delete(
                    webinarKey: $webinarKey,
                    registrantKey: $registrantKey,
                    organizerKey: null
                )->json();

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

    });
