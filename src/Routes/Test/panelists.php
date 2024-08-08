<?php

use Slakbal\Gotowebinar\Exceptions\RequiresReAuthorizationException;
use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\GotoApi;

Route::prefix('webinars')->name('goto.')
    ->group(function () {

        $gotoApi = new GotoApi;

        Route::get('/{webinarKey}/panelists', function ($webinarKey) use ($gotoApi) {
            try {
                return $gotoApi->panelists()->all(
                    webinarKey: $webinarKey,
                    organizerKey: null,
                    page: 0, //max is 200
                    limit: 10
                )->json();
            } catch (RequiresReAuthorizationException $e) {
                return redirect()->route('goto.authorize');
            }
        });

        Route::get('/{webinarKey}/panelists/create', function ($webinarKey) use ($gotoApi) {

            //takes and array of PanelistDtos
            $panelists = [
                //Make use of the DTO to create a panelist since it ensures data integrity
                new \Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Dtos\CreatePanelistDto(
                    name: 'Jack Sparrow',
                    email: 'jack.sparrow@gmail.com',
                ),
                new \Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Dtos\CreatePanelistDto(
                    name: 'Peter Pan',
                    email: 'peter.pan@gmail.com',
                ),
            ];

            try {
                return $gotoApi->panelists()->create(
                    panelistDtoArray: $panelists,
                    webinarKey: $webinarKey,
                    resendConfirmation: true,
                    organizerKey: null
                )->json();
            } catch (RequiresReAuthorizationException $e) {
                return redirect()->route('goto.authorize');
            }
        });

        Route::get('/{webinarKey}/panelists/{panelistKey}/resend-invitation', function ($webinarKey, $panelistKey) use ($gotoApi) {
            try {
                $response = $gotoApi->panelists()->resendInvitation(
                    webinarKey: $webinarKey,
                    panelistKey: $panelistKey,
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

        Route::get('/{webinarKey}/panelists/{panelistKey}/cancel', function ($webinarKey, $panelistKey) use ($gotoApi) {
            try {
                $response = $gotoApi->panelists()->delete(
                    webinarKey: $webinarKey,
                    panelistKey: $panelistKey,
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
