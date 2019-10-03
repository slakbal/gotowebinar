<?php

Route::get('webinars/{webinarKey}/sessions/{sessionKey}/attendees', function ($webinarKey, $sessionKey) {
    try {
        $response = Attendees::webinarKey($webinarKey)
                             ->sessionKey($sessionKey)
                             ->get();

        return [$response];
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {
        return [$e->getMessage()];
    }
});

Route::get('webinars/{webinarKey}/sessions/{sessionKey}/attendees/{registrantKey}', function ($webinarKey, $sessionKey, $registrantKey) {
    try {
        $response = Attendees::webinarKey($webinarKey)
                             ->sessionKey($sessionKey)
                             ->registrantKey($registrantKey) //todo GotoIssue: looking up a registrant by the registrantKey returns "Not Found"
                             ->get();

        return [$response];
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {
        return [$e->getMessage()];
    }
});

Route::get('webinars/{webinarKey}/sessions/{sessionKey}/attendees/{registrantKey}/polls', function ($webinarKey, $sessionKey, $registrantKey) {
    try {
        $response = Attendees::webinarKey($webinarKey)
                             ->sessionKey($sessionKey)
                             ->registrantKey($registrantKey) //todo GotoIssue: looking up a registrant by the registrantKey returns "Not Found"
                             ->polls()
                             ->get();

        return [$response];
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {
        return [$e->getMessage()];
    }
});

Route::get('webinars/{webinarKey}/sessions/{sessionKey}/attendees/{registrantKey}/questions', function ($webinarKey, $sessionKey, $registrantKey) {
    try {
        $response = Attendees::webinarKey($webinarKey)
                             ->sessionKey($sessionKey)
                             ->registrantKey($registrantKey) //todo GotoIssue: looking up a registrant by the registrantKey returns "Not Found"
                             ->questions()
                             ->get();

        return [$response];
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {
        return [$e->getMessage()];
    }
});

Route::get('webinars/{webinarKey}/sessions/{sessionKey}/attendees/{registrantKey}/surveys', function ($webinarKey, $sessionKey, $registrantKey) {
    try {
        $response = Attendees::webinarKey($webinarKey)
                             ->sessionKey($sessionKey)
                             ->registrantKey($registrantKey) //todo GotoIssue: looking up a registrant by the registrantKey returns "Not Found"
                             ->surveys()
                             ->get();

        return [$response];
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {
        return [$e->getMessage()];
    }
});
