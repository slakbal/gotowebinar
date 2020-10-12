<?php

namespace Slakbal\Gotowebinar\Commands;

use Illuminate\Console\Command;
use Slakbal\Gotowebinar\Facade\Webinars;

class GoToAccessTokenCommand extends Command
{

    protected $signature = 'goto:access-token {--flush} {--flush-only}';

    protected $description = 'Exchange the authorization code for an access-token.';

    public function handle()
    {
        if(($flush_only = $this->option('flush-only')) || $this->option('flush')) {
            $result = Webinars::flushAuthentication()->status();
            $this->call('cache:clear', );

            if($flush_only) {
                $this->showResult($result);
                return;
            }
        }

        $result = (array)Webinars::authenticate()->status();

        if(!empty($result)) {
            if(array_key_exists('access_token', $result)) {
                $this->info("Access-Token received:\n");
                $this->showResult($result);
            }
            return;
        }

        $this->error('Failed to retrieve Access-Token');
    }

    protected function showResult($result)
    {
        $this->table(['ready', 'access-token', 'refresh_token', 'organiser_key', 'account_key'], [$result]);
    }

}