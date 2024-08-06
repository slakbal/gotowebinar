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
                    page: 0,
                    limit: 10 //max is 200
                )->json('data');
            } catch (RequiresReAuthorizationException $e) {
                return redirect()->route('goto.authorize');
            }
        });

        Route::get('/{webinarKey}/registrants/create', function ($webinarKey) use ($gotoApi) {

            //Make use of the DTO to create a webinar since it ensures data integrity
            $registrantDto = new \Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Dtos\CreateRegistrantDto(
                firstName: 'Leslie',
                lastName: 'Price',
                email: 'leslie.price78@gmail.com',
                organization: 'Test Organisation',
            );

            try {
                return $gotoApi->registrants()->create(
                    registrantDto: $registrantDto,
                    webinarKey: $webinarKey
                )->json();
            } catch (RequiresReAuthorizationException $e) {
                return redirect()->route('goto.authorize');
            }
        });

        Route::get('/{webinarKey}/registrants/{registrantKey}', function ($webinarKey, $registrantKey) use ($gotoApi) {
            try {
                return $gotoApi->registrants()->get(
                    registrantKey: $registrantKey,
                    webinarKey: $webinarKey
                )->json();
            } catch (RequiresReAuthorizationException $e) {
                return redirect()->route('goto.authorize');
            }
        });

    });
