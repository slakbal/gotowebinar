<?php

Route::get('account', function () {
    $from = Carbon\Carbon::now()->subYears(50)->startOfDay();
    $to = Carbon\Carbon::now()->addYears(50)->endOfDay();

    // Example: _goto/account?page=10&size=1
    $page = request()->query('page') ?? 0;
    $size = request()->query('size') ?? 5;

    try {
        return Webinars::byAccountKey()
                       ->fromTime($from)
                       ->toTime($to)
                       ->page($page)
                       ->size($size)
                       ->get();
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {
        return [$e->getMessage()];
    }
});

Route::get('webinars', function () {
    $from = Carbon\Carbon::now()->subYear()->startOfDay();
    $to = Carbon\Carbon::tomorrow()->endOfDay();

    // Example: _goto/webinars?page=10&size=1
    $page = request()->query('page') ?? 0;
    $size = request()->query('size') ?? 5;

    try {
        return Webinars::fromTime($from)
                       ->toTime($to)
                       ->page($page)
                       ->size($size)
                       ->get();
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {
        return [$e->getMessage()];
    }
});

Route::get('webinars/{webinarKey}/view', function ($webinarKey) {
    try {
        return Webinars::webinarKey($webinarKey)
                       ->get();
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {
        return [$e->getMessage()];
    }
});

Route::get('webinars/create', function () {
    try {
        return Webinars::subject('XXXXX EVENT SUBJECT XXXXX*')
                       ->description('Event Description*')
                       ->timeFromTo(Carbon\Carbon::now()->addDays(10), Carbon\Carbon::now()->addDays(10)->addHours(1))
                       ->timeZone('Europe/Amsterdam')
                       ->singleSession()
                       ->noEmailReminder()
                       ->noEmailAttendeeFollowUp()
                       ->noEmailAbsenteeFollowUp()
                       ->noEmailConfirmation()
                       ->create();
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {
        return [$e->getMessage()];
    }
});

Route::get('webinars/createByArray', function () {

    //todo GotoIssue: still work to do on creating by array ie DateTimes and test if the validation is working on create

    try {
        return Webinars::noEmailReminder()
                       ->timeFromTo(Carbon\Carbon::now()->addDays(10), Carbon\Carbon::now()->addDays(10)->addHours(1))
                       ->create([
                                    'subject' => 'XXXXX EVENT SUBJECT XXXXX*',
                                    'description' => 'Event Description*',
                                    'timeZone' => 'Europe/Amsterdam',
                                    'type' => 'single_session', //single_session
                                    'isPasswordProtected' => false, //default is false
                                ]);
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {
        return [$e->getMessage()];
    }
});

Route::get('webinars/{webinarKey}/update', function ($webinarKey) {
    try {
        return Webinars::webinarKey($webinarKey)
                       ->subject('XXXXX EVENT UPDATED SUBJECT XXXXX*')
                       ->description('Event Updated Description*')
                       ->timeFromTo(Carbon\Carbon::now()->addDays(10)->midDay(), Carbon\Carbon::now()->addDays(10)->midDay()->addHours(2))
                       ->update();
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {
        return [$e->getMessage()];
    }
});

Route::get('webinars/{webinarKey}/updateByArray', function ($webinarKey) {

    //todo GotoIssue: still work to do on creating by array ie DateTimes and test if the validation is working on update

    try {
        return Webinars::webinarKey($webinarKey)
                       ->timeFromTo(Carbon\Carbon::now()->addDays(10), Carbon\Carbon::now()->addDays(10)->addHours(2))
                       ->update([
                                    'subject' => 'XXXXX EVENT UPDATED SUBJECT XXXXX*',
                                    'description' => 'Event Updated Description*',
                                    'timeZone' => 'Europe/Amsterdam',
                                    'isPasswordProtected' => false, //default is false
                                ]);
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {
        return [$e->getMessage()];
    }
});

Route::get('webinars/{webinarKey}/delete', function ($webinarKey) {
    try {
        return Webinars::webinarKey($webinarKey)
                       ->sendCancellationEmails()
                       ->delete();
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {
        return [$e->getMessage()];
    }
});

Route::get('webinars/{webinarKey}/attendees', function ($webinarKey) {

    // Example: attendees?page=10&size=1
    $page = request()->query('page') ?? 0;
    $size = request()->query('size') ?? 5;

    try {
        return Webinars::webinarKey($webinarKey)
                       ->attendees()
                       ->page($page)
                       ->size($size)
                       ->get();
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {
        return [$e->getMessage()];
    }
});

Route::get('webinars/{webinarKey}/meetingtimes', function ($webinarKey) {
    try {
        return Webinars::webinarKey($webinarKey)
                       ->meetingTimes()
                       ->get();
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {
        return [$e->getMessage()];
    }
});

Route::get('webinars/{webinarKey}/audio', function ($webinarKey) {
    try {
        return Webinars::webinarKey($webinarKey)
                       ->audio()
                       ->get();
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {
        return [$e->getMessage()];
    }
});

Route::get('webinars/{webinarKey}/performance', function ($webinarKey) {
    try {
        return Webinars::webinarKey($webinarKey)
                       ->performance()
                       ->get();
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {
        return [$e->getMessage()];
    }
});

Route::get('webinars/insession', function () {
    $from = Carbon\Carbon::now()->subYears(50)->startOfDay();
    $to = Carbon\Carbon::now()->addYears(50)->endOfDay();

    try {
        return Webinars::insessionWebinars()
                       ->fromTime($from)
                       ->toTime($to)
                       ->get();
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {
        return [$e->getMessage()];
    }
});
