<?php

Route::controller(\Slakbal\Gotowebinar\Http\Controllers\LocalController::class)
    ->prefix('goto/test')
    ->name('goto.')
    ->group(function () {

        //Account
        Route::get('accountDto', 'getAccountDto')->name('getAccountDto');
        Route::get('accountDtoResponse', 'getAccountDtoResponse')->name('getAccountDtoResponse');
        Route::get('accountJson', 'getAccountJson')->name('getAccountJson');
        Route::get('accountId', 'getAccountId')->name('getAccountId');
        Route::get('getAllWebinars', 'getAllWebinars')->name('getAllWebinars');

        //flush all the cached values
        Route::get('flush', 'flushCache')->name('flushCache');

    });
