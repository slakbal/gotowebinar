<?php

//explicitly applying the web group middleware for the test routes
//so that the session driver is started that will keep the authentication
//credentials

Route::prefix('_goto')->middleware(['web'])->group(function () {
    require_once __DIR__.'/state.php';
    require_once __DIR__.'/webinars.php';
    require_once __DIR__.'/registrants.php';
    require_once __DIR__.'/attendees.php';
//    require_once __DIR__.'/sessions.php';
//    require_once __DIR__.'/objects.php';
});
