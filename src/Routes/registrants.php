<?php

Route::get('webinars/{webinarKey}/registrants', function ($webinarKey) {
    try {
        $response = Registrants::webinarKey($webinarKey)
                               ->get();

        return [$response];
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {
        return [$e->getMessage()];
    }
});

Route::get('webinars/{webinarKey}/registrants/create', function ($webinarKey) {
    try {
        $response = Registrants::webinarKey($webinarKey)
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

        return [$response];
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {
        return [$e->getMessage()];
    }
});

Route::get('webinars/{webinarKey}/registrants/{registrantKey}/view', function ($webinarKey, $registrantKey) {

    /*
     * joinUrl: "https://global.gotowebinar.com/join/7850650863195083275/739529690",
     * registrantKey: 6820277626085326000,
     */

    try {
        $response = Registrants::webinarKey($webinarKey)
                               ->registrantKey($registrantKey)
                               ->get();

        return [$response];
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {
        return [$e->getMessage()];
    }
});

Route::get('webinars/{webinarKey}/registrants/{registrantKey}/delete', function ($webinarKey, $registrantKey) {

    /*
     * joinUrl: "https://global.gotowebinar.com/join/7850650863195083275/739529690",
     * registrantKey: 6820277626085326000,
     */

    try {
        $response = Registrants::webinarKey($webinarKey)
                               ->registrantKey($registrantKey)
                               ->delete();

        return [$response];
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {
        return [$e->getMessage()];
    }
});
