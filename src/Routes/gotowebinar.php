<?php

Route::controller(\Slakbal\Gotowebinar\Http\Controllers\OAuthController::class)->prefix('goto')->name('goto.')->group(function () {
    Route::get('authorize', 'handleAuthorization')->name('authorize');
    Route::get('callback', 'handleCallback')->name('callback');
});
