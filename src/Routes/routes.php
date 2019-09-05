<?php

//explicitly apply the web group middleware so that the session is started for the provider

Route::prefix('_goto')->middleware(['web'])->group(function () {
    require_once __DIR__.'/state.php';
    require_once __DIR__.'/webinars.php';
    require_once __DIR__.'/registrants.php';
//    require_once __DIR__.'/sessions.php';
//    require_once __DIR__.'/objects.php';
});
