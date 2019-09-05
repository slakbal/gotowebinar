<?php

namespace Slakbal\Gotowebinar\Objects;

class Registrant extends EntityAbstract
{
    //Query Param: resendConfirmation (boolean)
    /*
        {
          "firstName": "string",
          "lastName": "string",
          "email": "string",
          "source": "string",
          "address": "string",
          "city": "string",
          "state": "string",
          "zipCode": "string",
          "country": "string",
          "timeZone": "string",
          "phone": "string",
          "organization": "string",
          "jobTitle": "string",
          "questionsAndComments": "string",
          "industry": "string",
          "numberOfEmployees": "string",
          "purchasingTimeFrame": "string",
          "purchasingRole": "string"
        }
    */

    //required
    public $firstName;
    public $lastName;
    public $email;

    //optional
    public $source;
    public $address;
    public $city;
    public $state;
    public $zipCode;
    public $country;
    public $timeZone;
    public $phone;
    public $organization;
    public $jobTitle;
    public $questionsAndComments;
    public $industry;
    public $numberOfEmployees;
    public $purchasingTimeFrame;
    public $purchasingRole;

    //HEADER - Privates are hidden from the payload to the API CLIENT

    //Indicates whether the confirmation email should be resent when a registrant is re-registered. The default value is false.
    private $resendConfirmation = false;

    public function __construct($parameterArray = null)
    {
        if (isset($parameterArray) && is_array($parameterArray)) {

            //required
            $this->firstName($parameterArray['firstName']); //required
            $this->lastName($parameterArray['lastName']); //required
            $this->email($parameterArray['email']); //required

            //optional
            $this->source($parameterArray['source'] ?? null);
            $this->address($parameterArray['address'] ?? null);
            $this->city($parameterArray['city'] ?? null);
            $this->state($parameterArray['state'] ?? null);
            $this->zipCode($parameterArray['zipCode'] ?? null);
            $this->country($parameterArray['country'] ?? null);
            $this->timeZone($parameterArray['timeZone'] ?? null);
            $this->phone($parameterArray['phone'] ?? null);
            $this->organization($parameterArray['organization'] ?? null);
            $this->jobTitle($parameterArray['jobTitle'] ?? null);
            $this->questionsAndComments($parameterArray['questionsAndComments'] ?? null);
            $this->industry($parameterArray['industry'] ?? null);
            $this->numberOfEmployees($parameterArray['numberOfEmployees'] ?? null);
            $this->purchasingTimeFrame($parameterArray['purchasingTimeFrame'] ?? null);
            $this->purchasingRole($parameterArray['purchasingRole'] ?? null);

            //query parameter
            isset($parameterArray['resendConfirmation']) ? $parameterArray['resendConfirmation'] ? $this->resendConfirmation() : null : null;
        }
    }

    public function firstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function lastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function email($email)
    {
        $this->email = $email;

        return $this;
    }

    public function source($source = null)
    {
        $this->source = $source;

        return $this;
    }

    public function address($address = null)
    {
        $this->address = $address;

        return $this;
    }

    public function city($city = null)
    {
        $this->city = $city;

        return $this;
    }

    public function state($state = null)
    {
        $this->state = $state;

        return $this;
    }

    public function zipCode($zipCode = null)
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function country($country = null)
    {
        $this->country = $country;

        return $this;
    }

    public function timezone($timezone = null)
    {
        $this->timeZone = (new Timezone($timezone))->getTimezone();

        return $this;
    }

    public function phone($phone = null)
    {
        $this->phone = $phone;

        return $this;
    }

    public function organization($organization = null)
    {
        $this->organization = $organization;

        return $this;
    }

    public function jobTitle($jobTitle = null)
    {
        $this->jobTitle = $jobTitle;

        return $this;
    }

    public function questionsAndComments($questionsAndComments = null)
    {
        $this->questionsAndComments = $questionsAndComments;

        return $this;
    }

    public function industry($industry = null)
    {
        $this->industry = $industry;

        return $this;
    }

    public function numberOfEmployees($numberOfEmployees = null)
    {
        $this->numberOfEmployees = $numberOfEmployees;

        return $this;
    }

    public function purchasingTimeFrame($purchasingTimeFrame = null)
    {
        $this->purchasingTimeFrame = $purchasingTimeFrame;

        return $this;
    }

    public function purchasingRole($purchasingRole = null)
    {
        $this->purchasingRole = $purchasingRole;

        return $this;
    }

    public function resendConfirmation()
    {
        $this->resendConfirmation = true;

        return $this;
    }

    public function getResendConfirmation()
    {
        return $this->resendConfirmation;
    }
}
