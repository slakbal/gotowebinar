<?php

Route::get('/webinar/array', function () {

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
        'isPasswordProtected' => true,
    ];

    $webinar = new \Slakbal\Gotowebinar\Objects\Webinar($eventParams);

    return $webinar->toArray();
});

Route::get('/webinar/object', function () {

    $webinar = (new \Slakbal\Gotowebinar\Objects\Webinar())
        ->subject('XXXXX Test XXXXX*')
        ->description('Object Description*')
        ->timeFromTo(Carbon\Carbon::now()->addDays(2)->toW3cString(), Carbon\Carbon::now()->addDays(2)->addHour()->toW3cString())
        ->timezone('Europe/Amsterdam')
        ->locale('de_DE')
        ->singleSession()
        ->classic()
        ->isPasswordProtected()
        ->noEmailConfirmation()
        ->noEmailReminder()
        ->noEmailAbsenteeFollowUp()
        ->noEmailAttendeeFollowUp();

    return $webinar->toArray();
});

Route::get('/registrant/array', function () {

    $registrantParams = [
        'firstName' => 'Peter',
        'lastName' => 'Pan',
        'email' => 'peter.pan@example.com',
    ];

    $registrant = new \Slakbal\Gotowebinar\Objects\Registrant($registrantParams);

    return $registrant->toArray();
});

Route::get('/registrant/object', function () {

    $registrant = (new \Slakbal\Gotowebinar\Objects\Registrant())

        //required
        ->firstName('Peter')
        ->lastName('Pan')
        ->email('peter.pan@example.com')

        //optional
        ->source('Akademie')
        ->address('123 Test Street')
        ->city('Berlin')
        ->state('Berlin State')
        ->zipCode('12345')
        ->country('Germany')
        ->phone('+27 12 123 1234')
        ->organization('The Coding Company')
        ->jobTitle('Main Developer')
        ->questionsAndComments('Please let me know if there is something that is going to happen')
        ->industry('Software development')
        ->numberOfEmployees('123')
        ->purchasingTimeFrame('next 6 months')
        ->purchasingRole('Main chap')

        //Indicates whether the confirmation email should be resent when a registrant is re-registered. The default value is false.
        ->resendConfirmation();

    return $registrant->toArray();
});