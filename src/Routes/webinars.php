<?php

Route::get('webinars', function () {

    $parameters = [
        'fromTime' => Carbon\Carbon::now()->subYears(5)->toW3cString(),
        //"2017-06-01T00:00:00Z",
        'toTime' => Carbon\Carbon::now()->addYears(5)->toW3cString(),
    ];

    try {

        $gotoResponse = GotoWebinar::getWebinars($parameters);
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {

        return [$e->getMessage()];
    }

    return [$gotoResponse];
});

/*

Route::get('webinars/', function () {

    try {

        $gotoResponse = GotoWebinar::getUpcomingWebinars();
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {

        return [$e->getMessage()];
    }

    return [$gotoResponse];
});

Route::get('webinars/account', function () {

    $parameters = [
        'fromTime' => Carbon\Carbon::now()->subYears(5)->toW3cString(),
        //"2017-06-01T00:00:00Z",
        'toTime' => Carbon\Carbon::now()->addYears(5)->toW3cString(),
        'size' => 10,
        'page' => 1,
    ];

    try {

        $gotoResponse = GotoWebinar::getAllWebinars($parameters);
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {

        return [$e->getMessage()];
    }

    return [$gotoResponse];
});



Route::get('webinars/historical', function () {

    $parameters = [
        'fromTime' => "2017-01-01T00:00:00Z",
        'toTime' => "2017-05-01T00:00:00Z",
    ];

    try {

        $gotoResponse = GotoWebinar::getHistoricalWebinars($parameters);
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {

        return [$e->getMessage()];
    }

    return [$gotoResponse];
});

Route::get('webinars/create', function () {

    //Some of the body parameters are set per default but can explicitly be overridden.
    $eventParams = [
        //required
        'subject' => 'XXXXX Test XXXXX*',
        //required
        'description' => 'Test Description*',
        //required  eg "2016-03-23T19:00:00Z"
        'startTime' => Carbon\Carbon::now()->addDays(2)->toW3cString(),
        //require eg "2016-03-23T20:00:00Z"
        'endTime' => Carbon\Carbon::now()->addDays(2)->addHour()->toW3cString(),
        //if not given the config('app.timezone) will be used
        'timeZone' => 'Europe/Amsterdam',
        //if not given the default is single_session
        'type' => 'single_session',
        //if not given the default is false
        'isPasswordProtected' => false,
    ];

    try {

        $gotoResponse = GotoWebinar::createWebinar($eventParams);
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {

        return [$e->getMessage()];
    }

    return [$gotoResponse];
});

Route::get('webinars/{webinarKey}/update', function ($webinarKey) {

    //Some of the body parameters are set per default but can explicitly be overridden.
    $eventParams = [
        //required
        'subject' => 'XXXXX UPDATED to New Test XXXXX**',
        //required
        'description' => 'Updated Description**',
        //required  eg "2016-03-23T19:00:00Z"
        'startTime' => Carbon\Carbon::now()->addDays(3)->toW3cString(),
        //require eg "2016-03-23T20:00:00Z"
        'endTime' => Carbon\Carbon::now()->addDays(3)->addHour()->toW3cString(),
        //if not given the config('app.timezone) will be used
        'timeZone' => 'Africa/Harare',
        //if not given the default is single_session
        'type' => 'single_session',
        //if not given the default is false
        'isPasswordProtected' => true,
    ];

    try {

        $gotoResponse = GotoWebinar::updateWebinar($webinarKey, $eventParams, $sendNotification = true);
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {

        return [$e->getMessage()];
    }

    return [$gotoResponse];
});

Route::get('webinars/{webinarKey}/show', function ($webinarKey) {

    try {

        $gotoResponse = GotoWebinar::getWebinar($webinarKey);
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {

        return [$e->getMessage()];
    }

    return [$gotoResponse];
});

Route::get('webinars/{webinarKey}/delete', function ($webinarKey) {

    try {

        $gotoResponse = GotoWebinar::deleteWebinar($webinarKey, $sendNotification = false);
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {

        return [$e->getMessage()];
    }

    return [$gotoResponse];
});
*/