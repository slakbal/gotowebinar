<?php

Route::get('webinars/{webinarKey}/sessions', function ($webinarKey) {

    try {
        $gotoResponse = GotoWebinar::getSessions($webinarKey);
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {
        return [$e->getMessage()];
    }

    return [$gotoResponse];
});

Route::get('webinars/{webinarKey}/sessions/{sessionKey}/show', function ($webinarKey, $sessionKey) {

    try {
        $gotoResponse = GotoWebinar::getSession($webinarKey, $sessionKey);
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {
        return [$e->getMessage()];
    }

    return [$gotoResponse];
});

Route::get('webinars/{webinarKey}/sessions/{sessionKey}/performance', function ($webinarKey, $sessionKey) {

    try {
        $gotoResponse = GotoWebinar::getSessionPerformance($webinarKey, $sessionKey);
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {
        return [$e->getMessage()];
    }

    return [$gotoResponse];
});

Route::get('webinars/{webinarKey}/sessions/{sessionKey}/attendees', function ($webinarKey, $sessionKey) {

    try {
        $gotoResponse = GotoWebinar::getAttendees($webinarKey, $sessionKey);
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {
        return [$e->getMessage()];
    }

    return [$gotoResponse];
});

Route::get('webinars/{webinarKey}/sessions/{sessionKey}/attendees/{registrantKey}/show', function ($webinarKey, $sessionKey, $registrantKey) {

    try {
        $gotoResponse = GotoWebinar::getAttendee($webinarKey, $sessionKey, $registrantKey);
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {
        return [$e->getMessage()];
    }

    return [$gotoResponse];
});

Route::get('webinars/{webinarKey}/sessions/{sessionKey}/polls', function ($webinarKey, $sessionKey) {

    try {
        $gotoResponse = GotoWebinar::getSessionPolls($webinarKey, $sessionKey);
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {
        return [$e->getMessage()];
    }

    return [$gotoResponse];
});

Route::get('webinars/{webinarKey}/sessions/{sessionKey}/polls/{registrantKey}/answers', function ($webinarKey, $sessionKey, $registrantKey) {

    try {
        $gotoResponse = GotoWebinar::getAttendeePollAnswers($webinarKey, $sessionKey, $registrantKey);
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {
        return [$e->getMessage()];
    }

    return [$gotoResponse];
});