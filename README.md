# GotoWebinar API wrapper for Laravel

This package is a GotoWebinar API service wrapper and facade for Laravel 5.4+.

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
        "GotoWebinar": "Slakbal\\Gotowebinar\\Facade\\GotoWebinar"
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
  'GotoWebinar' => Slakbal\Gotowebinar\Facade\GotoWebinar::class
];
```


## Config

Before you can use the service provider you have configure it. You can create and App with API access keys here: [GotoWebinar Developer portal](https://goto-developer.logmeininc.com). Look for the `My Apps` menu.

Note that you need to have an active or trial account for the API to function properly. Just dev credentials alone might not work.

The provider currently only support `Direct` authentication. An OAuth2 authentication will be added at a later stage.

The package's configuration requires at a minimum the following environment values are required in your `.env` file.

```
GOTO_DIRECT_USER=test@test.com
GOTO_CONSUMER_SECRET=testpassword
GOTO_CONSUMER_KEY=123123123123
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

You will notice that there are some test routes, which you can look at for examples. Once your environment is in `production` in your `.env` file these routes will no longer be available.

```php
_goto                                                                           
_goto/webinars                                                                  
_goto/webinars/all                                                              
_goto/webinars/create                                                           
_goto/webinars/webinarKey}/sessions/{sessionKey}/attendees/{registrantKey}/show 
_goto/webinars/{webinarKey}/delete                                              
_goto/webinars/{webinarKey}/registrants                                         
_goto/webinars/{webinarKey}/registrants/create                                  
_goto/webinars/{webinarKey}/registrants/{registrantKey}/delete                  
_goto/webinars/{webinarKey}/registrants/{registrantKey}/show                    
_goto/webinars/{webinarKey}/sessions                                            
_goto/webinars/{webinarKey}/sessions/{sessionKey}/attendees                     
_goto/webinars/{webinarKey}/sessions/{sessionKey}/performance                   
_goto/webinars/{webinarKey}/sessions/{sessionKey}/show                          
_goto/webinars/{webinarKey}/show                                                
_goto/webinars/{webinarKey}/update                                              
```

## Usage

When using this package you'll notice it is closely aligned to the API documentation schemas etc. as can be found here: [GotoWebinar API Reference](https://goto-developer.logmeininc.com/content/gotowebinar-api-reference). It is recommended that you also keep an eye on the official API reference while implementing with this package.

### Examples

In the following location `vendor/slakbal/gotowebinar/src/routes` , there is a `routes.php` file with the above mentioned routes. 

For example:

```php
//Some of the body parameters have defaults, but can be explicitly overridden.
$eventParams = [                    
    //required
    'subject'             => 'XXXXX Test XXXXX*', //required
    'description'         => 'Test Description*', //required
    'startTime'           => Carbon::now()->addDays(2)->toW3cString(),              //required  eg "2016-03-23T19:00:00Z"
    'endTime'             => Carbon::now()->addDays(2)->addHour()->toW3cString(),   //require eg "2016-03-23T20:00:00Z"
    
    //optional with defaults
    'timeZone'            => 'Europe/Berlin',   //if not given the default is: config('app.timezone') from framework config
    'type'                => 'single_session',  //if not given the default is: single_session
    'isPasswordProtected' => false,             //if not given the default is: false
];


try {
    $gotoResponse = GotoWebinar::createWebinar($eventParams);
} catch (GotoException $e) {
    //do something or go somewhere or notifify someone
}


return $gotoResponse;
```

## Responses

The package automatically returns the response body so you can just access the expected results for example:

```php
//create a webinar
$gotoResponse = GotoWebinar::createWebinar($eventParams);
```

the API will send back a JSON response which will look like this:

```json
[
    {
        "webinarKey": "4255157664015486220"
    }
]
```

You can on the $gotoResponse directly access the properties in the response object:

```php
$gotoResponse->webinarKey
```

## Exception Handling and Logging

When using the package methods it is recommended to call them within a `try`, `catch` block. For example:
 
```php
try {
    $gotoResponse = GotoWebinar::createWebinar($eventParams);
} catch (GotoException $e) {
    return [$e->getMessage()];
    //or send a notification
}
``` 

The package will automatically log most errors for you to the Laravel log file, so you don't need to log them again. For example:

```php
[2017-09-21 00:14:38] local.ERROR: GOTOWEBINAR: DELETE - Not Found (404): Webinar with specified key does not exist.
```

## GotoWebinar Resources

### getUpcomingWebinars

Returns the list of all upcoming Webinars

```php
GotoWebinar::getUpcomingWebinars();
```

### getAllWebinars

Returns the list of all upcoming Webinars

```php
$parameters = [
    'fromTime' => Carbon::now()->subYears(5)->toW3cString(), //"2017-06-01T00:00:00Z",
    'toTime'   => Carbon::now()->addYears(5)->toW3cString(),
];

GotoWebinar::getAllWebinars($parameters);
```

### createWebinar

Create a Webinar - date format standard: W3C - ISO 8601

```php
//Some of the body parameters are set per default but can explicitly be overridden.
$eventParams = [
    'subject'             => 'XXXXX Test XXXXX*',   //required
    'description'         => 'Test Description*',   //required
    'startTime'           => Carbon::now()->addDays(2)->toW3cString(),              //required  eg "2016-03-23T19:00:00Z"
    'endTime'             => Carbon::now()->addDays(2)->addHour()->toW3cString(),   //require eg "2016-03-23T20:00:00Z"
    'timeZone'            => 'Europe/Berlin',   //if not given the config('app.timezone) from the framework will be used
    'type'                => 'single_session',  //if not given the default is single_session
    'isPasswordProtected' => false,             //if not given the default is false
];

$gotoResponse = GotoWebinar::createWebinar($eventParams);
```

### updateWebinar

Update a Webinar - date format standard: W3C - ISO 8601, method returns `true` or `false`

```php
//Some of the body parameters are set per default but can explicitly be overridden.
$eventParams = [
    'subject'             => 'XXXXX UPDATE Test2 XXXXX**',  //required
    'description'         => 'Updated Description**',       //required
    'startTime'           => Carbon::now()->addDays(3)->toW3cString(),              //required  eg "2016-03-23T19:00:00Z"
    'endTime'             => Carbon::now()->addDays(3)->addHour()->toW3cString(),   //require eg "2016-03-23T20:00:00Z"
    'timeZone'            => 'America/New_York',    //if not given the config('app.timezone) from the framework will be used
    'type'                => 'single_session',      //if not given the default is single_session
    'isPasswordProtected' => true,                  //if not given the default is false
];

$gotoResponse = GotoWebinar::updateWebinar($webinarKey, $eventParams, $sendNotification = true);
```

### getWebinar

Return a specific Webinar by webinarKey

```php
GotoWebinar::getWebinar($webinarKey);
```

#### deleteWebinar

Delete a specific Webinar by webinarKey, method returns `true` or `false`

```php
GotoWebinar::deleteWebinar($webinarKey, $sendNotification = false);
```

### getRegistrants

Return a list of registrants for a specific Webinar

```php
GotoWebinar::getRegistrants($webinarKey);
```

#### getRegistrants

Return a list of registrants for a specific Webinar

```php
GotoWebinar::getRegistrants($webinarKey);
```

### createRegistrant

Create a registrant for a specific WebinarKey

```php
$attendeeParams = [
    //required
    'firstName'             => 'Peter',
    'lastName'              => 'Pan',
    'email'                 => 'peter.pan@example.com',

    //optional
    //empty fields will be filtered out an not sent with the request
    'timeZone'              => 'America/Sao_Paulo',
    'organization'          => 'Test Organisation',
    'source '               => '',
    'address '              => '',
    'city '                 => '',
    'state '                => '',
    'zipCode '              => '',
    'country '              => '',
    'phone '                => '',
    'jobTitle '             => '',
    'questionsAndComments ' => '',
    'industry '             => '',
    'numberOfEmployees '    => '',
    'purchasingTimeFrame '  => '',
    'purchasingRole '       => '',
];

$gotoResponse = GotoWebinar::createRegistrant($webinarKey, $attendeeParams, $resendConfirmation = false);
```

### getRegistrants

Return a specific registrant by webinarKey and registrantKey

```php
GotoWebinar::getRegistrant($webinarKey, $registrantKey);
```

### deleteRegistrant

Delete a specific registrant by webinarKey and registrantKey

```php
GotoWebinar::deleteRegistrant($webinarKey, $registrantKey);
```

### getSessions

Return the session of a webinar by webinarKey

```php
GotoWebinar::getSessions($webinarKey);
```

### getSession

Return a specific session by webinarKey and sessionKey

```php
GotoWebinar::getSession($webinarKey, $sessionKey);
```

### getSessionPerformance

Return the performance of a specific session by webinarKey and sessionKey

```php
GotoWebinar::getSessionPerformance($webinarKey, $sessionKey);
```

### getAttendees

Return the attendees of a specific session by webinarKey and sessionKey

```php
GotoWebinar::getAttendees($webinarKey, $sessionKey);
```

### getAttendee

Return a specif attendee of a specific session by webinarKey and sessionKey

```php
GotoWebinar::getAttendee($webinarKey, $sessionKey);
```


Your contribution or bug fixes are welcome!

Enjoy!

Slakkie
