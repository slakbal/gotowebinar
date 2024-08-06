<?php

use Slakbal\Gotowebinar\Exceptions\RequiresReAuthorizationException;
use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\GotoApi;

Route::prefix('registrant')->name('goto.')
    ->group(function () {

        $gotoApi = new GotoApi;

        Route::get('getAllRegistrants/{webinarKey}', function ($webinarKey) use ($gotoApi) {
            try {
                return $gotoApi->registrants()->all(
                    webinarKey: $webinarKey,
                    page: 0,
                    limit: 2 //max is 200
                )->json('data');
            } catch (RequiresReAuthorizationException $e) {
                return redirect()->route('goto.authorize');
            }
        })->name('getAllRegistrants');

        Route::get('flush', function () use ($gotoApi) {
            return [$gotoApi->flushCache()];
        })->name('flushCache');

    });
