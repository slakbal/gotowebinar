<?php
/*
Route::get('webinars/{webinarKey}/attendees', function ($webinarKey) {

    // Example: attendees?page=10&size=1
    $page = request()->query('page') ?? 0;
    $size = request()->query('size') ?? 5;

    try {
        return Attendees::webinarKey($webinarKey)
                        ->page($page)
                        ->size($size)
                        ->get();
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {
        return [$e->getMessage()];
    }
});
*/
