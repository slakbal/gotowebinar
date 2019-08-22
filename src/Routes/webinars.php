<?php

use Slakbal\Gotowebinar\Objects\Webinar;

Route::get('webinars', function () {

    $parameters = [
        'fromTime' => Carbon\Carbon::now()->subYears(5)->toW3cString(), //"2017-06-01T00:00:00Z",
        'toTime' => Carbon\Carbon::now()->addYears(5)->toW3cString(),
        'page' => 1,
        'size' => 10,
    ];

    try {
        $gotoResponse = GotoWebinar::getWebinars($parameters);
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {
        return [$e->getMessage()];
    }

    return [$gotoResponse];
});

Route::get('webinars/account', function () {

    $parameters = [
        'fromTime' => Carbon\Carbon::now()->subYears(5)->toW3cString(),
        'toTime' => Carbon\Carbon::now()->addYears(5)->toW3cString(),
        'page' => 1,
        'size' => 10,
    ];

    try {
        $gotoResponse = GotoWebinar::getAccountWebinars($parameters);
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {
        return [$e->getMessage()];
    }

    return [$gotoResponse];
});

Route::get('webinars/create', function () {

    //see Webinar class for available methods
    $webinarValueObject = (new Webinar())->subject('XXXXX CREATED BY OBJECT XXXXX*')
                                         ->description('OBJECT Description*')
                                         ->timeFromTo(Carbon\Carbon::now()->addDays(2)->toW3cString(), Carbon\Carbon::now()->addDays(2)->addHour()->toW3cString())
                                         ->timezone('Europe/Amsterdam')
                                         ->singleSession()
                                         ->noEmailReminder()
                                         ->noEmailAttendeeFollowUp()
                                         ->noEmailAbsenteeFollowUp()
                                         ->noEmailConfirmation();

    try {
        $gotoResponse = GotoWebinar::createWebinar($webinarValueObject);
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {
        return [$e->getMessage()];
    }

    return [$gotoResponse];
});

Route::get('webinars/createByArray', function () {

    //Some of the body parameters are set per default but can explicitly be overridden.
    $eventArray = [
        'subject' => 'XXXXX CREATED BY ARRAY XXXXX*',
        'description' => 'Test Description*',
        'startTime' => Carbon\Carbon::now()->addDays(2)->toW3cString(), //require eg "2016-03-23T20:00:00Z"
        'endTime' => Carbon\Carbon::now()->addDays(2)->addHour()->toW3cString(), //require eg "2016-03-23T20:00:00Z"
        'timeZone' => 'Europe/Amsterdam',
        'type' => 'single_session', //single_session
        'isPasswordProtected' => false, //default is false
    ];

    //cast the array through the Webinar value-object constructor to initialise the value object and ensure all the data is structured correctly
    $webinarValueObject = new Webinar($eventArray);

    //see Webinar class for available public methods
    $webinarValueObject->noEmailReminder()
                       ->noEmailAttendeeFollowUp()
                       ->noEmailAbsenteeFollowUp()
                       ->noEmailConfirmation();

    try {
        $gotoResponse = GotoWebinar::createWebinar($webinarValueObject);
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

Route::get('webinars/{webinarKey}/update', function ($webinarKey) {

    //see Webinar class for available methods
    $webinarValueObject = (new Webinar())->subject('XXXXX UPDATED BY OBJECT XXXXX*')
                                         ->description('UPDATED Description*')
                                         ->timeFromTo(Carbon\Carbon::now()->addDays(3)->toW3cString(), Carbon\Carbon::now()->addDays(3)->addHour()->toW3cString())
                                         ->timezone('Africa/Harare')
                                         ->singleSession()
                                         ->EmailReminder()
                                         ->EmailAttendeeFollowUp()
                                         ->EmailAbsenteeFollowUp()
                                         ->EmailConfirmation();

    try {
        //return boolean
        $gotoResponse = GotoWebinar::updateWebinar($webinarKey, $webinarValueObject, $sendNotification = true);
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {
        return [$e->getMessage()];
    }

    return [$gotoResponse];
});

Route::get('webinars/{webinarKey}/delete', function ($webinarKey) {

    try {
        //return boolean
        $gotoResponse = GotoWebinar::deleteWebinar($webinarKey, $sendNotification = false);
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {
        return [$e->getMessage()];
    }

    return [$gotoResponse];
});