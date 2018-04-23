<?php

use Carbon\Carbon;
use Slakbal\Gotowebinar\Exception\GotoException;
use Slakbal\Gotowebinar\Facade\GotoWebinar;

//apply the web group middleware so that the session is started for the provider
Route::prefix('_goto')->middleware(['web'])->group(function () {


    Route::get('/', function () {

        try {

            $gotoResponse = GotoWebinar::state(false);
            //$gotoResponse = GotoWebinar::refreshToken();

        } catch (GotoException $e) {

            return [$e->getMessage()];

        }

        return [$gotoResponse];
    });

    Route::prefix('webinars')->group(function () {


        Route::get('/', function () {

            try {

                $gotoResponse = GotoWebinar::getUpcomingWebinars();

            } catch (GotoException $e) {

                return [$e->getMessage()];

            }

            return [$gotoResponse];

        });


        Route::get('account', function () {


            $parameters = [
                'fromTime' => Carbon::now()->subYears(5)->toW3cString(),
                //"2017-06-01T00:00:00Z",
                'toTime'   => Carbon::now()->addYears(5)->toW3cString(),
                'size'     => 10,
                'page'     => 1,
            ];

            try {

                $gotoResponse = GotoWebinar::getAllWebinars($parameters);

            } catch (GotoException $e) {

                return [$e->getMessage()];

            }

            return [$gotoResponse];
        });



        Route::get('all', function () {


            $parameters = [
                'fromTime' => Carbon::now()->subYears(5)->toW3cString(),
                //"2017-06-01T00:00:00Z",
                'toTime'   => Carbon::now()->addYears(5)->toW3cString(),
            ];

            try {

                $gotoResponse = GotoWebinar::getAllWebinars($parameters);

            } catch (GotoException $e) {

                return [$e->getMessage()];

            }

            return [$gotoResponse];
        });


        Route::get('historical', function () {


            $parameters = [
                'fromTime' => "2017-01-01T00:00:00Z",
                'toTime'   => "2017-05-01T00:00:00Z",
            ];

            try {

                $gotoResponse = GotoWebinar::getHistoricalWebinars($parameters);

            } catch (GotoException $e) {

                return [$e->getMessage()];

            }

            return [$gotoResponse];
        });


        Route::get('create', function () {

            //Some of the body parameters are set per default but can explicitly be overridden.
            $eventParams = [
                //required
                'subject'             => 'XXXXX Test XXXXX*',
                //required
                'description'         => 'Test Description*',
                //required  eg "2016-03-23T19:00:00Z"
                'startTime'           => Carbon::now()->addDays(2)->toW3cString(),
                //require eg "2016-03-23T20:00:00Z"
                'endTime'             => Carbon::now()->addDays(2)->addHour()->toW3cString(),
                //if not given the config('app.timezone) will be used
                'timeZone'            => 'Europe/Berlin',
                //if not given the default is single_session
                'type'                => 'single_session',
                //if not given the default is false
                'isPasswordProtected' => false,
            ];

            try {

                $gotoResponse = GotoWebinar::createWebinar($eventParams);

            } catch (GotoException $e) {

                return [$e->getMessage()];

            }

            return [$gotoResponse];

        });


        Route::get('{webinarKey}/update', function ($webinarKey) {

            //Some of the body parameters are set per default but can explicitly be overridden.
            $eventParams = [
                //required
                'subject'             => 'XXXXX UPDATED to New Test XXXXX**',
                //required
                'description'         => 'Updated Description**',
                //required  eg "2016-03-23T19:00:00Z"
                'startTime'           => Carbon::now()->addDays(3)->toW3cString(),
                //require eg "2016-03-23T20:00:00Z"
                'endTime'             => Carbon::now()->addDays(3)->addHour()->toW3cString(),
                //if not given the config('app.timezone) will be used
                'timeZone'            => 'Africa/Johannesburg',
                //if not given the default is single_session
                'type'                => 'single_session',
                //if not given the default is false
                'isPasswordProtected' => true,
            ];

            try {

                $gotoResponse = GotoWebinar::updateWebinar($webinarKey, $eventParams, $sendNotification = true);

            } catch (GotoException $e) {

                return [$e->getMessage()];

            }

            return [$gotoResponse];

        });


        Route::get('{webinarKey}/show', function ($webinarKey) {

            try {

                $gotoResponse = GotoWebinar::getWebinar($webinarKey);

            } catch (GotoException $e) {

                return [$e->getMessage()];

            }

            return [$gotoResponse];

        });


        Route::get('{webinarKey}/delete', function ($webinarKey) {

            try {

                $gotoResponse = GotoWebinar::deleteWebinar($webinarKey, $sendNotification = false);

            } catch (GotoException $e) {

                return [$e->getMessage()];

            }

            return [$gotoResponse];

        });


        Route::get('{webinarKey}/registrants', function ($webinarKey) {

            try {

                $gotoResponse = GotoWebinar::getRegistrants($webinarKey);

            } catch (GotoException $e) {

                return [$e->getMessage()];

            }

            return [$gotoResponse];
        });


        Route::get('{webinarKey}/registrants/create', function ($webinarKey) {

            try {
                //Some of the body parameters are set per default but can explicitly be overridden.
                $attendeeParams = [
                    //required
                    'firstName'             => 'Peter',
                    'lastName'              => 'Pan',
                    'email'                 => 'peter.pan@example.com',

                    //optional empty fields will be filtered out an not sent with the request
                    'organization'          => 'Test Organisation',
                    'source '               => '',
                    'address '              => '',
                    'city '                 => '',
                    'state '                => '',
                    'zipCode '              => '',
                    'country '              => '',
                    'phone '                => '',
                    'jobTitle '             => '',
                    'questionsAndComments ' => '',
                    'industry '             => '',
                    'numberOfEmployees '    => '',
                    'purchasingTimeFrame '  => '',
                    'purchasingRole '       => '',
                ];

                //do the API call
                $gotoResponse = GotoWebinar::createRegistrant($webinarKey, $attendeeParams, $resendConfirmation = false);

            } catch (GotoException $e) {

                return [$e->getMessage()];

            }

            return [$gotoResponse];

        });


        Route::get('{webinarKey}/registrants/{registrantKey}/show', function ($webinarKey, $registrantKey) {

            try {

                $gotoResponse = GotoWebinar::getRegistrant($webinarKey, $registrantKey);

            } catch (GotoException $e) {

                return [$e->getMessage()];

            }

            return [$gotoResponse];

        });


        Route::get('{webinarKey}/registrants/{registrantKey}/delete', function ($webinarKey, $registrantKey) {

            try {

                $gotoResponse = GotoWebinar::deleteRegistrant($webinarKey, $registrantKey);

            } catch (GotoException $e) {

                return [$e->getMessage()];

            }

            return [$gotoResponse];

        });

        Route::get('{webinarKey}/sessions', function ($webinarKey) {

            try {

                $gotoResponse = GotoWebinar::getSessions($webinarKey);

            } catch (GotoException $e) {

                return [$e->getMessage()];

            }

            return [$gotoResponse];
        });


        Route::get('{webinarKey}/sessions/{sessionKey}/show', function ($webinarKey, $sessionKey) {

            try {

                $gotoResponse = GotoWebinar::getSession($webinarKey, $sessionKey);

            } catch (GotoException $e) {

                return [$e->getMessage()];

            }

            return [$gotoResponse];
        });


        Route::get('{webinarKey}/sessions/{sessionKey}/performance', function ($webinarKey, $sessionKey) {

            try {

                $gotoResponse = GotoWebinar::getSessionPerformance($webinarKey, $sessionKey);

            } catch (GotoException $e) {

                return [$e->getMessage()];

            }

            return [$gotoResponse];
        });


        Route::get('{webinarKey}/sessions/{sessionKey}/attendees', function ($webinarKey, $sessionKey) {

            try {

                $gotoResponse = GotoWebinar::getAttendees($webinarKey, $sessionKey);

            } catch (GotoException $e) {

                return [$e->getMessage()];

            }

            return [$gotoResponse];
        });


        Route::get('{webinarKey}/sessions/{sessionKey}/attendees/{registrantKey}/show', function ($webinarKey, $sessionKey, $registrantKey) {

            try {

                $gotoResponse = GotoWebinar::getAttendee($webinarKey, $sessionKey, $registrantKey);

            } catch (GotoException $e) {

                return [$e->getMessage()];

            }

            return [$gotoResponse];
        });


        Route::get('{webinarKey}/sessions/{sessionKey}/polls', function ($webinarKey, $sessionKey) {

            try {

                $gotoResponse = GotoWebinar::getSessionPolls($webinarKey, $sessionKey);

            } catch (GotoException $e) {

                return [$e->getMessage()];

            }

            return [$gotoResponse];
        });


        Route::get('{webinarKey}/sessions/{sessionKey}/polls/{registrantKey}/answers', function ($webinarKey, $sessionKey, $registrantKey) {

            try {

                $gotoResponse = GotoWebinar::getAttendeePollAnswers($webinarKey, $sessionKey, $registrantKey);

            } catch (GotoException $e) {

                return [$e->getMessage()];

            }

            return [$gotoResponse];
        });

    });

});