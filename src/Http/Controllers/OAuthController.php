<?php

namespace Slakbal\Gotowebinar\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\AuthConnector;

class OAuthController extends Controller
{
    public function handleAuthorization()
    {
        $connector = new AuthConnector;

        $authorizationUrl = $connector->getAuthorizationUrl();

        /*
         * Optional state value passed during the authorization session for CSRF protection
         * An opaque value used by the client to maintain state between the request and callback.
         * The authorization server includes this value when redirecting the user-agent back to the client.
         */
        Session::put('gotoAuthClientState', $connector->getState());

        //Redirect the user to our authorization URL
        return redirect()->to($authorizationUrl);
    }

    public function handleCallback(Request $request)
    {
        //Exchange the authorization code for an access token and refresh token -> Authenticator

        //Authorization
        $authorizationCode = $request->input('code');
        cache()->forever('gotoAuthorizationCode', $authorizationCode);

        //State for CSRF protection
        $receivedState = $request->input('state');
        $expectedState = Session::pull('gotoAuthClientState');

        //Get Authenticator and cache it
        $connector = new AuthConnector;
        $authenticator = $connector->getAccessToken($authorizationCode, $receivedState, $expectedState, false);

        cache()->forever('gotoAuthenticator', $authenticator->serialize());

        return redirect()->back();
    }
}
