<?php

namespace Slakbal\Gotowebinar\Entity;


class Registrant extends EntityAbstract
{

    /* Model Schema
    {
      "firstName": "string",
      "lastName": "string",
      "email": "string",
      "timeZone": "string",
      "source": "string",
      "address": "string",
      "city": "string",
      "state": "string",
      "zipCode": "string",
      "country": "string",
      "phone": "string",
      "organization": "string",
      "jobTitle": "string",
      "questionsAndComments": "string",
      "industry": "string",
      "numberOfEmployees": "string",
      "purchasingTimeFrame": "string",
      "purchasingRole": "string",
    }
    */

    //required
    public $firstName;
    public $lastName;
    public $email;

    //optional
    public $timeZone;
    public $organization;
    public $source;
    public $address;
    public $city;
    public $state;
    public $zipCode;
    public $country;
    public $phone;
    public $jobTitle;
    public $questionsAndComments;
    public $industry;
    public $numberOfEmployees;
    public $purchasingTimeFrame;
    public $purchasingRole;


    public function __construct($parameterArray = null)
    {
        if (isset($parameterArray) && is_array($parameterArray)) {

            $this->firstName = $parameterArray['firstName']; //required
            $this->lastName = $parameterArray['lastName']; //required
            $this->email = $parameterArray['email']; //required

            //optional
            $this->timeZone = (isset($parameterArray['timeZone']) ? $parameterArray['timeZone'] : config('app.timezone')); //framwork config
            $this->organization = (isset($parameterArray['organization']) ? $parameterArray['organization'] : null);
            $this->source = (isset($parameterArray['source']) ? $parameterArray['source'] : null);
            $this->address = (isset($parameterArray['address']) ? $parameterArray['address'] : null);
            $this->city = (isset($parameterArray['city']) ? $parameterArray['city'] : null);
            $this->state = (isset($parameterArray['state']) ? $parameterArray['state'] : null);
            $this->zipCode = (isset($parameterArray['zipCode']) ? $parameterArray['zipCode'] : null);
            $this->country = (isset($parameterArray['country']) ? $parameterArray['country'] : null);
            $this->phone = (isset($parameterArray['phone']) ? $parameterArray['phone'] : null);
            $this->jobTitle = (isset($parameterArray['jobTitle']) ? $parameterArray['jobTitle'] : null);
            $this->questionsAndComments = (isset($parameterArray['questionsAndComments']) ? $parameterArray['questionsAndComments'] : null);
            $this->industry = (isset($parameterArray['industry']) ? $parameterArray['industry'] : null);
            $this->numberOfEmployees = (isset($parameterArray['numberOfEmployees']) ? $parameterArray['numberOfEmployees'] : null);
            $this->purchasingTimeFrame = (isset($parameterArray['purchasingTimeFrame']) ? $parameterArray['purchasingTimeFrame'] : null);
            $this->purchasingRole = (isset($parameterArray['purchasingRole']) ? $parameterArray['purchasingRole'] : null);
        }
    }

}