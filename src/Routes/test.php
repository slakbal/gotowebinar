<?php

Route::prefix('_goto')->group(function () {
    require_once __DIR__.'/Test/account.php';
    require_once __DIR__.'/Test/webinars.php';
    require_once __DIR__.'/Test/registrants.php';
    require_once __DIR__.'/Test/panelists.php';
    require_once __DIR__.'/Test/sessions.php';
    require_once __DIR__.'/Test/helpers.php';
    require_once __DIR__.'/Test/organizers.php';
    require_once __DIR__.'/Test/attendees.php';
    //    require_once __DIR__.'/Test/attendees.php';
    //    require_once __DIR__.'/Test/sessions.php';
});
