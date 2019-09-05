<?php

Route::get('account', function () {
    $from = Carbon\Carbon::now()->subYears(50)->startOfDay();
    $to = Carbon\Carbon::now()->addYears(50)->endOfDay();

    return [
        \Slakbal\Gotowebinar\Facade\Webinars::byAccountKey()
                                            ->fromTime($from)
                                            ->toTime($to)
                                            ->page(0)
                                            ->size(5)
                                            ->get(),
    ];
});

Route::get('webinars', function () {
    $from = Carbon\Carbon::now()->subYear()->startOfDay();
    $to = Carbon\Carbon::tomorrow()->endOfDay();

    return [
        \Slakbal\Gotowebinar\Facade\Webinars::fromTime($from)
                                            ->toTime($to)
                                            ->page(0)
                                            ->size(5)
                                            ->get(),
    ];
});

Route::get('webinars/{webinarKey}/show', function ($webinarKey) {
    return [
        \Slakbal\Gotowebinar\Facade\Webinars::webinarKey($webinarKey)
                                            ->get(),
    ];
});

Route::get('webinars/create', function () {
    return [
        \Slakbal\Gotowebinar\Facade\Webinars::subject('XXXXX CREATED BY OBJECT XXXXX*')
                                            ->description('OBJECT Description*')
                                            ->timeFromTo(Carbon\Carbon::now()->addDays(2), Carbon\Carbon::now()->addDays(2)->addHours(2))
                                            ->timezone('Europe/Amsterdam')
                                            ->singleSession()
                                            ->noEmailReminder()
                                            ->noEmailAttendeeFollowUp()
                                            ->noEmailAbsenteeFollowUp()
                                            ->noEmailConfirmation()
                                            ->create(),
    ];
});

Route::get('webinars/createByArray', function () {

    //todo still work to do on creating by array ie DateTimes and test if the validation is working on create

    return [
        \Slakbal\Gotowebinar\Facade\Webinars::noEmailReminder()
                                            ->timeFromTo(Carbon\Carbon::now()->addDays(2), Carbon\Carbon::now()->addDays(2)->addHours(2))
                                            ->create([
                                                         'subject' => 'XXXXX CREATED BY ARRAY XXXXX*',
                                                         'description' => 'Test Description*',
                                                         'timeZone' => 'Europe/Amsterdam',
                                                         'type' => 'single_session', //single_session
                                                         'isPasswordProtected' => false, //default is false
                                                     ]),
    ];
});

Route::get('webinars/{webinarKey}/update', function ($webinarKey) {
    return [
        \Slakbal\Gotowebinar\Facade\Webinars::webinarKey($webinarKey)
                                            ->subject('XXXXX UPDATED OBJECT XXXXX*')
                                            ->description('UPDATED Description*')
                                            ->timeFromTo(Carbon\Carbon::now()->addDays(2)->midDay(), Carbon\Carbon::now()->addDays(2)->midDay()->addHours(2))
                                            ->update(),
    ];
});

Route::get('webinars/{webinarKey}/delete', function ($webinarKey) {
    return [
        \Slakbal\Gotowebinar\Facade\Webinars::webinarKey($webinarKey)
                                            ->sendCancellationEmails()
                                            ->delete(),
    ];
});
