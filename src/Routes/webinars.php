<?php

Route::get('account', function () {
    $from = Carbon\Carbon::now()->subYears(50)->startOfDay();
    $to = Carbon\Carbon::now()->addYears(50)->endOfDay();

    // Example: _goto/account?page=10&size=1
    $page = request()->query('page') ?? 0;
    $size = request()->query('size') ?? 5;

    try {
        $response = Webinars::byAccountKey()
                            ->fromTime($from)
                            ->toTime($to)
                            ->page($page)
                            ->size($size)
                            ->get();

        return [$response];
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
        $response = Webinars::fromTime($from)
                            ->toTime($to)
                            ->page($page)
                            ->size($size)
                            ->get();

        return [$response];
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {
        return [$e->getMessage()];
    }
});

Route::get('webinars/{webinarKey}/view', function ($webinarKey) {
    try {
        $response = Webinars::webinarKey($webinarKey)
                            ->get();

        return [$response];
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {
        return [$e->getMessage()];
    }
});

Route::get('webinars/create', function () {
    try {
        $response = Webinars::subject('XXXXX EVENT SUBJECT XXXXX')
                            ->description('Event Description')
                            ->timeFromTo(Carbon\Carbon::now()->addDays(10), Carbon\Carbon::now()->addDays(10)->addHours(1))
                            ->timeZone('Europe/Amsterdam')
                            ->singleSession()
                            ->noEmailReminder()
                            ->noEmailAttendeeFollowUp()
                            ->noEmailAbsenteeFollowUp()
                            ->noEmailConfirmation()
                            ->create();

        return [$response];
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {
        return [$e->getMessage()];
    }
});

Route::get('webinars/createByArray', function () {
    try {
        $response = Webinars::noEmailReminder()
                            ->timeFromTo(Carbon\Carbon::now()->addDays(10), Carbon\Carbon::now()->addDays(10)->addHours(1))
                            ->create([
                                         'subject' => 'XXXXX EVENT SUBJECT XXXXX',
                                         'description' => 'Event Description',
                                         'timeZone' => 'Europe/Amsterdam',
                                         'type' => 'single_session', //single_session
                                         'isPasswordProtected' => false, //default is false
                                     ]);

        return [$response];
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {
        return [$e->getMessage()];
    }
});

Route::get('webinars/{webinarKey}/update', function ($webinarKey) {
    try {
        $response = Webinars::webinarKey($webinarKey)
                            ->subject('XXXXX UPDATED EVENT SUBJECT XXXXX')
                            ->description('Updated Event Description')
                            ->timeFromTo(Carbon\Carbon::now()->addDays(10)->midDay(), Carbon\Carbon::now()->addDays(10)->midDay()->addHours(2))
                            ->sendUpdateNotifications()
                            ->update();

        return [$response];
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {
        return [$e->getMessage()];
    }
});

Route::get('webinars/{webinarKey}/updateByArray', function ($webinarKey) {
    try {
        $response = Webinars::webinarKey($webinarKey)
                            ->timeFromTo(Carbon\Carbon::now()->addDays(10), Carbon\Carbon::now()->addDays(10)->addHours(2))
                            ->update([
                                         'subject' => 'XXXXX UPDATED EVENT SUBJECT XXXXX',
                                         'description' => 'Updated Event Description',
                                         'timeZone' => 'Europe/Amsterdam',
                                         'isPasswordProtected' => false, //default is false
                                     ]);

        return [$response];
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {
        return [$e->getMessage()];
    }
});

Route::get('webinars/{webinarKey}/delete', function ($webinarKey) {
    try {
        $response = Webinars::webinarKey($webinarKey)
                            ->sendCancellationEmails()
                            ->delete();

        return [$response];
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {
        return [$e->getMessage()];
    }
});

Route::get('webinars/{webinarKey}/attendees', function ($webinarKey) {

    // Example: attendees?page=10&size=1
    $page = request()->query('page') ?? 0;
    $size = request()->query('size') ?? 5;

    try {
        $response = Webinars::webinarKey($webinarKey)
                            ->attendees()
                            ->page($page)
                            ->size($size)
                            ->get();

        return [$response];
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {
        return [$e->getMessage()];
    }
});

Route::get('webinars/{webinarKey}/meetingtimes', function ($webinarKey) {
    try {
        $response = Webinars::webinarKey($webinarKey)
                            ->meetingTimes()
                            ->get();

        return [$response];
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {
        return [$e->getMessage()];
    }
});

Route::get('webinars/{webinarKey}/audio', function ($webinarKey) {
    try {
        $response = Webinars::webinarKey($webinarKey)
                            ->audio()
                            ->get();

        return [$response];
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {
        return [$e->getMessage()];
    }
});

Route::get('webinars/{webinarKey}/performance', function ($webinarKey) {
    try {
        $response = Webinars::webinarKey($webinarKey)
                            ->performance()
                            ->get();

        return [$response];
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {
        return [$e->getMessage()];
    }
});

Route::get('webinars/insession', function () {
    $from = Carbon\Carbon::now()->subYears(50)->startOfDay();
    $to = Carbon\Carbon::now()->addYears(50)->endOfDay();

    try {
        $response = Webinars::insessionWebinars()
                            ->fromTime($from)
                            ->toTime($to)
                            ->get();

        return [$response];
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {
        return [$e->getMessage()];
    }
});
