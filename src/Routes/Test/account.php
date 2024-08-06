<?php

use Slakbal\Gotowebinar\Exceptions\RequiresReAuthorizationException;
use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\GotoApi;

Route::prefix('account')->name('goto.')
    ->group(function () {

        $gotoApi = new GotoApi;

        Route::get('accountDto', function () use ($gotoApi) {
            try {
                return [$gotoApi->account()->get()->dtoOrFail()];
            } catch (RequiresReAuthorizationException $e) {
                return redirect()->route('goto.authorize');
            }
        })->name('getAccountDtoResponse');

        Route::get('accountDtoResponse', function () use ($gotoApi) {
            try {
                return $gotoApi->account()->get()->dtoOrFail()->getResponse();
            } catch (RequiresReAuthorizationException $e) {
                return redirect()->route('goto.authorize');
            }
        })->name('getAccountDtoResponse');

        Route::get('accountJson', function () use ($gotoApi) {
            try {
                return $gotoApi->account()->get()->json();
            } catch (RequiresReAuthorizationException $e) {
                return redirect()->route('goto.authorize');
            }
        })->name('getAccountJson');

        Route::get('accountId', function () use ($gotoApi) {
            try {
                return $gotoApi->account()->get()->json('id');
            } catch (RequiresReAuthorizationException $e) {
                return redirect()->route('goto.authorize');
            }
        })->name('getAccountId');

    });
