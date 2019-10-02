<?php

Route::get('sessions', function () {
    $from = Carbon\Carbon::now()->subYears(50)->startOfDay();
    $to = Carbon\Carbon::now()->addYears(50)->endOfDay();

    // Example: sessions?page=10&size=1
    $page = request()->query('page') ?? 0;
    $size = request()->query('size') ?? 5;

    try {
        return Sessions::organizerSessions()
                       ->fromTime($from)
                       ->toTime($to)
                       ->page($page)
                       ->size($size)
                       ->get();
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {
        return [$e->getMessage()];
    }
});

Route::get('webinars/{webinarKey}/sessions', function ($webinarKey) {

    // Example: sessions?page=10&size=1
    $page = request()->query('page') ?? 0;
    $size = request()->query('size') ?? 5;

    try {
        return Sessions::webinarKey($webinarKey)
                       ->page($page)
                       ->size($size)
                       ->get();
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {
        return [$e->getMessage()];
    }
});

Route::get('webinars/{webinarKey}/sessions/{sessionKey}', function ($webinarKey, $sessionKey) {
    try {
        return Sessions::webinarKey($webinarKey)
                       ->sessionKey($sessionKey)
                       ->get();
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {
        return [$e->getMessage()];
    }
});

Route::get('webinars/{webinarKey}/sessions/{sessionKey}/performance', function ($webinarKey, $sessionKey) {
    try {
        return Sessions::webinarKey($webinarKey)
                       ->sessionKey($sessionKey)
                       ->performance()
                       ->get();
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {
        return [$e->getMessage()];
    }
});

Route::get('webinars/{webinarKey}/sessions/{sessionKey}/polls', function ($webinarKey, $sessionKey) {
    try {
        return Sessions::webinarKey($webinarKey)
                       ->sessionKey($sessionKey)
                       ->polls()
                       ->get();
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {
        return [$e->getMessage()];
    }
});

Route::get('webinars/{webinarKey}/sessions/{sessionKey}/questions', function ($webinarKey, $sessionKey) {
    try {
        return Sessions::webinarKey($webinarKey)
                       ->sessionKey($sessionKey)
                       ->questions()
                       ->get();
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {
        return [$e->getMessage()];
    }
});

Route::get('webinars/{webinarKey}/sessions/{sessionKey}/surveys', function ($webinarKey, $sessionKey) {
    try {
        return Sessions::webinarKey($webinarKey)
                       ->sessionKey($sessionKey)
                       ->surveys()
                       ->get();
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {
        return [$e->getMessage()];
    }
});