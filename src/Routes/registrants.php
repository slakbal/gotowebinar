<?php

use Slakbal\Gotowebinar\Objects\Registrant;

Route::get('webinars/{webinarKey}/registrants', function ($webinarKey) {

    try {
        $gotoResponse = GotoWebinar::getRegistrants($webinarKey);
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {
        return [$e->getMessage()];
    }

    return [$gotoResponse];
});

Route::get('webinars/{webinarKey}/attendees', function ($webinarKey) {

    try {

        //If no parameters are sent in, the default page size is 20
        $parameters = [
            'page' => 1,
            'size' => 10,
        ];

        $gotoResponse = GotoWebinar::getAttendees($webinarKey, $parameters);
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {
        return [$e->getMessage()];
    }

    return [$gotoResponse];
});

Route::get('webinars/{webinarKey}/registrants/create', function ($webinarKey) {

    try {

        //see Registrant class for available methods
        $registrantValueObject = (new Registrant())->firstName('Peter')
                                                   ->lastName('Pan')
                                                   ->email('peter.pan@example.com')
                                                   ->timezone('America/Chicago')
                                                   ->questionsAndComments('Please dial me in');

        $gotoResponse = GotoWebinar::createRegistrant($webinarKey, $registrantValueObject, $resendConfirmation = false);
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {
        return [$e->getMessage()];
    }

    return [$gotoResponse];
});

Route::get('webinars/{webinarKey}/registrants/createByArray', function ($webinarKey) {

    try {
        $registrantArray = [
            //required
            'firstName' => 'Peter',
            'lastName' => 'Pan',
            'email' => 'peter.pan@example.com',

            //optional empty fields will be filtered out an not sent with the request
            'organization' => 'Test Organisation',
            'source' => 'Some Source',
            'address' => '123 Some Street',
            'city' => 'Some City',
            'state' => 'Some State',
            'zipCode' => '1234',
            'country' => 'United States',
            'timeZone' => 'Europe/Amsterdam',
            'phone' => '+1 123 1234 123',
            'jobTitle' => 'Sales Director',
            'questionsAndComments' => 'Can you please dial me into the meeting?',
            'industry' => 'Some Industry',
            'numberOfEmployees' => '5',
            'purchasingTimeFrame' => 'end of september 2019',
            'purchasingRole' => 'Some purchase role',
        ];

        //cast the array through the value-object constructor to initialise the value object and ensure all the data is structured correctly
        $registrantValueObject = new Registrant($registrantArray);

        $gotoResponse = GotoWebinar::createRegistrant($webinarKey, $registrantValueObject, $resendConfirmation = false);
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {
        return [$e->getMessage()];
    }

    return [$gotoResponse];
});

Route::get('webinars/{webinarKey}/registrants/{registrantKey}/show', function ($webinarKey, $registrantKey) {

    try {
        $gotoResponse = GotoWebinar::getRegistrant($webinarKey, $registrantKey);
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {
        return [$e->getMessage()];
    }

    return [$gotoResponse];
});

Route::get('webinars/{webinarKey}/registrants/{registrantKey}/delete', function ($webinarKey, $registrantKey) {

    try {
        $gotoResponse = GotoWebinar::deleteRegistrant($webinarKey, $registrantKey);
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {
        return [$e->getMessage()];
    }

    return [$gotoResponse];
});