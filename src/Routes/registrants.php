<?php

Route::get('webinars/{webinarKey}/registrants', function ($webinarKey) {
    try {
        return Registrants::webinarKey($webinarKey)
                          ->get();
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {
        return [$e->getMessage()];
    }
});

Route::get('webinars/{webinarKey}/registrants/create', function ($webinarKey) {
    try {
        return Registrants::webinarKey($webinarKey)
                          ->firstName('John')
                          ->lastName('Doe')
                          ->timeZone('America/Chicago')
                          ->email('john.doe@email.com')
                          ->resendConfirmation()
                          ->questionsAndComments('Some First Question')
                          ->create([
                                       'firstName' => 'Peters',
                                       'lastName' => 'Panske',
                                       'email' => 'peter@pan.com',
                                       'timezone' => 'Europe/Amsterdam',
                                       'phone' => '123',
                                       'country' => 'SA',
                                       'zipcode' => '123',
                                       'source' => 'somewhere',
                                       'address' => '123 Some street',
                                       'city' => 'Some City',
                                       'state' => 'Some State',
                                       'organization' => 'Some Org',
                                       'jobTitle' => 'Boss',
                                       'questionsAndComments' => 'Some Question',
                                       'industry' => 'Some Industry',
                                       'numberOfEmployees' => 'Boss',
                                       'purchasingTimeFrame' => 'Very soon',
                                       'purchasingRole' => 'Some Buyer Role',
                                   ]);
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {
        return [$e->getMessage()];
    }
});

Route::get('webinars/{webinarKey}/registrants/{registrantKey}/show', function ($webinarKey, $registrantKey) {
    try {
        return Registrants::webinarKey($webinarKey)
                          ->registrantKey($registrantKey)
                          ->get();
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {
        return [$e->getMessage()];
    }
});

Route::get('webinars/{webinarKey}/registrants/{registrantKey}/delete', function ($webinarKey, $registrantKey) {
    try {
        return Registrants::webinarKey($webinarKey)
                          ->registrantKey($registrantKey)
                          ->delete();
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {
        return [$e->getMessage()];
    }
});
