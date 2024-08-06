<?php

use Carbon\CarbonImmutable;
use Slakbal\Gotowebinar\Exceptions\RequiresReAuthorizationException;
use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\GotoApi;

Route::prefix('goto/test')->name('goto.')
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

        Route::get('getAllWebinars', function () use ($gotoApi) {
            try {
                return $gotoApi->webinars()->all(
                    fromTime: CarbonImmutable::now()->subMonths(24),
                    toTime: CarbonImmutable::now(),
                    page: 0,
                    size: 20
                )->json();
            } catch (RequiresReAuthorizationException $e) {
                return redirect()->route('goto.authorize');
            }
        })->name('getAllWebinars');

        Route::get('getWebinar/{webinarKey}', function ($webinarKey) use ($gotoApi) {
            try {
                return $gotoApi->webinars()->get(
                    webinarKey: $webinarKey
                )->json();
            } catch (RequiresReAuthorizationException $e) {
                return redirect()->route('goto.authorize');
            }
        })->name('getWebinar');

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
