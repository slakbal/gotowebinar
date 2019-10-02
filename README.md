# GotoWebinar API wrapper for Laravel

This package is a GotoWebinar API service wrapper and facade for Laravel 5.4+.

This new release makes use of the latest version of the GotoWebinar API and Authentication methods. This release is not compatible with the previous versions and is a complete new implementation. 

## Compatible API Version

https://goto-developer.logmeininc.com/content/gotowebinar-api-reference-v2

## Known Issues

* There are still some issues with the deletion of Registrants from a Webinar by registrantKey
* Retrieving session attendees by registrantKey

## Contributions and Bug

Please create a pull request for any changes, update or bugs. Thanks!

## Installing

You can use Composer to install the library

```
composer require slakbal/gotowebinar
```

If you have Laravel 5.5+ the package will be auto-discovered:

```json
  "extra": {
    "laravel": {
      "providers": [
        "Slakbal\\Gotowebinar\\GotoWebinarServiceProvider"
      ],
      "aliases": {
        "Webinars": "Slakbal\\Gotowebinar\\Facade\\Webinars",
        "Registrants": "Slakbal\\Gotowebinar\\Facade\\Registrants",
        "Attendees": "Slakbal\\Gotowebinar\\Facade\\Attendees"
      }
    }
  },
```

Otherwise, find the `providers` array in the `config/app.php` file and add the following Service Provider:

```php
'providers' => [
  // ...
  Slakbal\Gotowebinar\GotoWebinarServiceProvider::class
];
```

Now find the `aliases` array in the same config file and add the following Facade class:

```php
'aliases' => [
  // ...
  'Webinars' => Slakbal\\Gotowebinar\\Facade\\Webinars,
  'Registrants' => Slakbal\\Gotowebinar\\Facade\\Registrants,
  'Attendees' => Slakbal\\Gotowebinar\\Facade\\Attendees
  'Sessions' => Slakbal\\Gotowebinar\\Facade\\Sessions
];
```


## Config

Before you can use the service provider you have configure it. You can create and App with API access keys here: [GotoWebinar Developer portal](https://goto-developer.logmeininc.com). Look for the `My Apps` menu.

Note that you need to have an active or trial account for the API to function properly. Just dev credentials alone might not work since those tokens are sometimes restricted or expire.

The provider currently only support [OAuth2](https://goto-developer.logmeininc.com/how-get-access-token-and-organizer-key) authentication. Since this is used for backend integration and not clients like for examples mobile applications, etc. the initial authentication is done via Goto's [Direct Login](https://goto-developer.logmeininc.com/how-use-direct-login). 

The package's configuration requires at a minimum the following environment values are required in your `.env` file.

```
GOTO_CONSUMER_KEY=Oa0fdvd82FdXcLrsts3EQYdsuGhdscV41
GOTO_CONSUMER_SECRET=8mbIGtkfdfhjksad68
GOTO_DIRECT_USERNAME=webinars@company.com
GOTO_DIRECT_PASSWORD=Password
```

The provider can also publish it's config. You can publish the configuration file if you want to with:

```php
php artisan vendor:publish
```

## Dev Environment

In your development environment, when you run the following artisan command:

```php
php artisan route:list
```

You will notice that there are some test routes, which you can look at for examples and use in the browser to test your integration with. Once your environment is in `production` in your `.env` file these routes will no longer be available.

```php
_goto
_goto/ping
_goto/authenticate
_goto/flush-auth
_goto/webinars
_goto/webinars/create
_goto/webinars/createByArray
_goto/webinars/{webinarKey}/view
_goto/webinars/{webinarKey}/update
_goto/webinars/{webinarKey}/updateByArray
_goto/webinars/{webinarKey}/registrants
_goto/webinars/{webinarKey}/registrants/create
_goto/webinars/{webinarKey}/registrants/{registrantKey}/view
_goto/webinars/{webinarKey}/registrants/{registrantKey}/delete
_goto/webinars/{webinarKey}/attendees
_goto/webinars/{webinarKey}/delete
_goto/webinars/{webinarKey}/sessions
_goto/webinars/{webinarKey}/sessions/{sessionKey}
_goto/webinars/{webinarKey}/sessions/{sessionKey}/performance
_goto/webinars/{webinarKey}/sessions/{sessionKey}/polls
_goto/webinars/{webinarKey}/sessions/{sessionKey}/questions
_goto/webinars/{webinarKey}/sessions/{sessionKey}/surveys
_goto/webinars/{webinarKey}/sessions/{sessionKey}/attendees
_goto/webinars/{webinarKey}/sessions/{sessionKey}/attendees/{registrantKey}
_goto/webinars/{webinarKey}/sessions/{sessionKey}/attendees/{registrantKey}/polls
_goto/webinars/{webinarKey}/sessions/{sessionKey}/attendees/{registrantKey}/questions
_goto/webinars/{webinarKey}/sessions/{sessionKey}/attendees/{registrantKey}/surveys
```

## Authentication Token Caching

Once your config values are set the authentication tokens etc. are cached and expiry and refreshing of tokens are automatically managed!

**Note a cache which support [tags](https://laravel.com/docs/5.8/cache#storing-tagged-cache-items) is required. Thus file or database cache drivers are not supported.**

So caching the token results in one less round trip to GotoWebinar servers thus improved performance. If you want to manipulate the state manually the following methods can be used:

```php    
    Webinars::status();
    
    //note methods are also chainable
    Webinars::authenticate()->status(); 

    Webinars::flushAuthentication()->status();
```

## Usage

When using this package you'll notice it is closely aligned to the API documentation schemas etc. as can be found here: [GotoWebinar API v2](https://goto-developer.logmeininc.com/content/gotowebinar-api-reference-v2). It is recommended that you also keep an eye on the official API reference while implementing with this package.

#### Examples

In the following location `vendor/slakbal/gotowebinar/src/routes` , there are route files with the above mentioned routes which can be used to see usage of the package.

For example:

```php
    try {
        return Webinars::subject('Event Name')
                       ->description('Event Description*')
                       ->timeFromTo(Carbon::now()->addDays(10), Carbon::now()->addDays(10)->addHours(1))
                       ->timeZone('Europe/Amsterdam')
                       ->singleSession()
                       ->noEmailReminder()
                       ->noEmailAttendeeFollowUp()
                       ->noEmailAbsenteeFollowUp()
                       ->noEmailConfirmation()
                       ->create();
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {
        return [$e->getMessage()];
    }
```

Response:

```json
    {
        "webinarKey": "4255157664015486220"
    }
```

You can now on $gotoResponse directly access the properties in the response object:

```php
$gotoResponse->webinarKey
```

## Exception Handling and Logging

When using the package methods it is recommended to call them within a `try`, `catch` block. For example:

```php
try {
    $gotoResponse = GotoWebinar::createWebinar($eventParams);
} catch (GotoException $e) {
    //do something, go somewhere or notifify someone
}
```

The package will automatically log some major events and response errors for you to your configured Laravel log file, so you don't need to log them again. For example:

```php
[2017-09-21 00:14:38] local.ERROR: GOTOWEBINAR: DELETE - Not Found (404): Webinar with specified key does not exist.
```

## GotoWebinar Resources

## Webinars

#### Get Webinars (Fluent)

```php
    $from = Carbon::now()->subYear()->startOfDay();
    $to = Carbon::tomorrow()->endOfDay();

    // Example URL: _goto/webinars?page=10&size=1
    $page = request()->query('page') ?? 0;
    $size = request()->query('size') ?? 5;

    try {
        return Webinars::fromTime($from)
                       ->toTime($to)
                       ->page($page)
                       ->size($size)
                       ->get();
    } catch (Slakbal\Gotowebinar\Exception\GotoException $e) {
        return [$e->getMessage()];
    }
```
#### Create Webinar (Fluent)

```php
    return Webinars::subject('Event Name')
                   ->description('Event Description')
                   ->timeFromTo(Carbon::now()->addDays(10), Carbon::now()->addDays(10)->addHours(1))
                   ->timeZone('Europe/Amsterdam')
                   ->singleSession()
                   ->noEmailReminder()
                   ->noEmailAttendeeFollowUp()
                   ->noEmailAbsenteeFollowUp()
                   ->noEmailConfirmation()
                   ->create();
```
#### Create Webinar (Array)

```php
    return Webinars::noEmailReminder()
                   ->timeFromTo(Carbon::now()->addDays(10), Carbon::now()->addDays(10)->addHours(1))
                   ->create([
                                'subject' => 'Event Name',
                                'description' => 'Event Description*',
                                'timeZone' => 'Europe/Amsterdam',
                                'type' => 'single_session',
                                'isPasswordProtected' => false,
                            ]);
```
#### Update Webinar (Fluent)

```php
    return Webinars::webinarKey($webinarKey)
                   ->subject('Updated Event Name')
                   ->description('Updated Event Description*')
                   ->timeFromTo(Carbon::now()->addDays(10)->midDay(), Carbon::now()->addDays(10)->midDay()->addHours(2))
                   ->update();
```
#### Update Webinar (Array)

```php
    return Webinars::webinarKey($webinarKey)
                   ->timeFromTo(Carbon::now()->addDays(10), Carbon::now()->addDays(10)->addHours(2))
                   ->update([
                                'subject' => 'Event Name',
                                'description' => 'UPDATED Event Description',
                                'timeZone' => 'Europe/Amsterdam',
                                'isPasswordProtected' => false,
                            ]);
```
#### Show Webinar (Fluent)

```php
    return Webinars::webinarKey($webinarKey)
                   ->get();
```

#### Delete Webinar (Fluent)

Delete a specific Webinar by webinarKey, method returns `true` or `false`

```php
    return Webinars::webinarKey($webinarKey)
                   ->sendCancellationEmails()
                   ->delete();
```
#### Webinar Attendees (Fluent)

```php
    return Webinars::webinarKey($webinarKey)
                    ->page($page)
                    ->size($size)
                    ->get();
```
#### Webinar Meeting Times (Fluent)

```php
    return Webinars::webinarKey($webinarKey)
                   ->meetingTimes()
                   ->get();
```
#### Webinar Audio (Fluent)

```php
    return Webinars::webinarKey($webinarKey)
                   ->audio()
                   ->get();
```
#### Webinar Performance (Fluent)

```php
    return Webinars::webinarKey($webinarKey)
                   ->performance()
                   ->get();
```
#### Webinars In-Session (Fluent)

```php
    $from = Carbon::now()->subYears(50)->startOfDay();
    $to = Carbon::now()->addYears(50)->endOfDay();

    return Webinars::insessionWebinars()
                    ->fromTime($from)
                    ->toTime($to)
                    ->get();
```

## Registrants

#### Get Registrants (Fluent)

Return a list of registrants for a specific Webinar

```php
    return Registrants::webinarKey($webinarKey)
                      ->get();
```

#### Create Registrant (Fluent)

Create a registrant for a specific WebinarKey

```php
    return Registrants::webinarKey($webinarKey)
                      ->firstName('John')
                      ->lastName('Doe')
                      ->timeZone('America/Chicago')
                      ->email('john.doe@email.com')
                      ->resendConfirmation()
                      ->questionsAndComments('Some First Question')
                      ->create();
```
#### Create Registrant (Array)

Create a registrant for a specific WebinarKey

```php
    return Registrants::webinarKey($webinarKey)
                      ->resendConfirmation()
                      ->create([
                                   'firstName' => 'Peters',
                                   'lastName' => 'Panske',
                                   'email' => 'peter@pan.com',
                                   'timezone' => 'Europe/Amsterdam',
                                   'phone' => '123',
                                   'country' => 'SA',
                                   'zipcode' => '123',
                                   'source' => 'somewhere',
                                   'address' => '123 Some street',
                                   'city' => 'Some City',
                                   'state' => 'Some State',
                                   'organization' => 'Some Org',
                                   'jobTitle' => 'Boss',
                                   'questionsAndComments' => 'Some Question',
                                   'industry' => 'Some Industry',
                                   'numberOfEmployees' => 'Boss',
                                   'purchasingTimeFrame' => 'Very soon',
                                   'purchasingRole' => 'Some Buyer Role',
                               ]);
```
#### Get Registrant (Fluent)

Return a specific registrant by webinarKey and registrantKey

```php
    return Registrants::webinarKey($webinarKey)
                      ->registrantKey($registrantKey)
                      ->get();
```

#### Delete Registrant (Fluent)

Delete a specific registrant by webinarKey and registrantKey, method returns `true` or `false`

```php
    return Registrants::webinarKey($webinarKey)
                      ->registrantKey($registrantKey)
                      ->delete();
```

## Sessions

#### Get Organizer Sessions (Fluent)

```php
    $from = Carbon\Carbon::now()->subYears(50)->startOfDay();
    $to = Carbon\Carbon::now()->addYears(50)->endOfDay();

    // Example: sessions?page=10&size=1
    $page = request()->query('page') ?? 0;
    $size = request()->query('size') ?? 5;

    return Sessions::organizerSessions()
                   ->fromTime($from)
                   ->toTime($to)
                   ->page($page)
                   ->size($size)
                   ->get();
```

#### Get Webinar Sessions (Fluent)

```php
    // Example: sessions?page=10&size=1
    $page = request()->query('page') ?? 0;
    $size = request()->query('size') ?? 5;

    return Sessions::webinarKey($webinarKey)
                   ->page($page)
                   ->size($size)
                   ->get();
```

#### Get Session (Fluent)

```php
    return Sessions::webinarKey($webinarKey)
                   ->sessionKey($sessionKey)
                   ->get();
```

#### Get Session Performance (Fluent)

```php
    return Sessions::webinarKey($webinarKey)
                   ->sessionKey($sessionKey)
                   ->performance()
                   ->get();
```

#### Get Session Polls (Fluent)

```php
    return Sessions::webinarKey($webinarKey)
                   ->sessionKey($sessionKey)
                   ->polls()
                   ->get();
```

#### Get Session Questions (Fluent)

```php
    return Sessions::webinarKey($webinarKey)
                   ->sessionKey($sessionKey)
                   ->questions()
                   ->get();
```

#### Get Session Surveys (Fluent)

```php
    return Sessions::webinarKey($webinarKey)
                   ->sessionKey($sessionKey)
                   ->surveys()
                   ->get();
```

## Attendees

#### Get Session Attendees (Fluent)

```php
    return Attendees::webinarKey($webinarKey)
                   ->sessionKey($sessionKey)
                   ->get();
```

#### Get Attendee (Fluent)

```php
    return Attendees::webinarKey($webinarKey)
                   ->sessionKey($sessionKey)
                   ->registrantKey($registrantKey)
                   ->get();
```

#### Get Attendee Polls (Fluent)

```php
    return Attendees::webinarKey($webinarKey)
                   ->sessionKey($sessionKey)
                   ->registrantKey($registrantKey)
                   ->polls()
                   ->get();
```

#### Get Attendee Questions (Fluent)

```php
    return Attendees::webinarKey($webinarKey)
                   ->sessionKey($sessionKey)
                   ->registrantKey($registrantKey)
                   ->questions()
                   ->get();
```

#### Get Attendee Surveys (Fluent)

```php
    return Attendees::webinarKey($webinarKey)
                   ->sessionKey($sessionKey)
                   ->registrantKey($registrantKey)
                   ->surveys()
                   ->get();
```

Your contribution or bug fixes are welcome!

Enjoy!

Slakkie
