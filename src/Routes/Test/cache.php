<?php

use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\GotoApi;

Route::prefix('cache')->name('goto.')
    ->group(function () {

        $gotoApi = new GotoApi;

        Route::get('flush', function () use ($gotoApi) {
            return [$gotoApi->flushCache()];
        })->name('flushCache');

    });
