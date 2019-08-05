<?php

Route::get('webinars/{webinarKey}/registrants', function ($webinarKey) {

    try {

        $gotoResponse = GotoWebinar::getRegistrants($webinarKey);
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {

        return [$e->getMessage()];
    }

    return [$gotoResponse];
});

Route::get('webinars/{webinarKey}/registrants/create', function ($webinarKey) {

    try {
        //Some of the body parameters are set per default but can explicitly be overridden.
        $attendeeParams = [
            //required
            'firstName' => 'Peter',
            'lastName' => 'Pan',
            'email' => 'peter.pan@example.com',

            //optional empty fields will be filtered out an not sent with the request
            'organization' => 'Test Organisation',
            'source ' => '',
            'address ' => '',
            'city ' => '',
            'state ' => '',
            'zipCode ' => '',
            'country ' => '',
            'phone ' => '',
            'jobTitle ' => '',
            'questionsAndComments ' => '',
            'industry ' => '',
            'numberOfEmployees ' => '',
            'purchasingTimeFrame ' => '',
            'purchasingRole ' => '',
        ];

        //do the API call
        $gotoResponse = GotoWebinar::createRegistrant($webinarKey, $attendeeParams, $resendConfirmation = false);
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