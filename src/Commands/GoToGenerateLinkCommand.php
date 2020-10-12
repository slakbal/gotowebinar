<?php

namespace Slakbal\Gotowebinar\Commands;

use Illuminate\Console\Command;

class GoToGenerateLinkCommand extends Command
{

    protected $signature = 'goto:generate-link {--state=}';

    protected $description = 'Generate an authorization link to receive an authorization code.
                              {--state} Pass a state to prevent cross-site request forgery';

    protected $scheme = 'https://api.getgo.com/oauth/v2/authorize?client_id={client_id}&response_type=code&redirect_uri={redirect_uri}{state}';

    public function handle()
    {
        $state = $this->option('state', null);

        // clear cache first
        $this->call('cache:clear');

        $link = str_replace([
            '{client_id}',
            '{redirect_uri}',
            '{state}'
        ], [
            config('goto.client_id'),
            // @todo: check if null?
            config('goto.redirect_uri'),
            $state ? "&state={$state}" : ''
        ], $this->scheme);

        $this->info("Click (or copy/paste) the following link to receive an authorization code.\n".
                           "If your browser is not logged in, you need to login once with your credentials.\n".
                           "The returned authorization code will be exchanged for an access-token and\n".
                           "invalidates after the exchange.\n\n".
                           "Read for more info: https://developer.goto.com/guides/HowTos/03_HOW_accessToken/\n\n");
        $this->line('-- Authorization link: ---------------------');
        $this->line($link);
        $this->line('============================================');
    }

}