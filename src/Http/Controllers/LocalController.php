<?php

namespace Slakbal\Gotowebinar\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\CarbonImmutable;
use Slakbal\Gotowebinar\Exceptions\RequiresReAuthorizationException;
use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\GotoApi;

class LocalController extends Controller
{
    protected GotoApi $gotoApi;

    public function __construct()
    {
        $this->gotoApi = new GotoApi;
    }

    public function flushCache()
    {
        return [$this->gotoApi->flushCache()];
    }

    public function getAccountDto()
    {
        try {
            return [$this->gotoApi->account()->getAccount()->dtoOrFail()];
        } catch (RequiresReAuthorizationException $e) {
            return redirect()->route('goto.authorize');
        }
    }

    public function getAccountDtoResponse()
    {
        try {
            return $this->gotoApi->account()->getAccount()->dtoOrFail()->getResponse();
        } catch (RequiresReAuthorizationException $e) {
            return redirect()->route('goto.authorize');
        }
    }

    public function getAccountJson()
    {
        try {
            return $this->gotoApi->account()->getAccount()->json();
        } catch (RequiresReAuthorizationException $e) {
            return redirect()->route('goto.authorize');
        }
    }

    public function getAccountId()
    {
        try {
            return $this->gotoApi->account()->getAccount()->json('id');
        } catch (RequiresReAuthorizationException $e) {
            return redirect()->route('goto.authorize');
        }
    }


    public function getAllWebinars()
    {
        try {
            return $this->gotoApi->webinars()->all(
                fromTime: CarbonImmutable::now()->subMonths(1),
                toTime: CarbonImmutable::now(),
                page: 0,
                size: 10
            )->json('_embedded.webinars');
        } catch (RequiresReAuthorizationException $e) {
            return redirect()->route('goto.authorize');
        }
    }
}
