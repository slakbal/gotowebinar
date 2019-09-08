<?php

Route::get('webinars/{webinarKey}/attendees', function ($webinarKey) {
    try {
        return Attendees::webinarKey($webinarKey)
                        ->page(0)
                        ->size(5)
                        ->get();
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {
        return [$e->getMessage()];
    }
});
