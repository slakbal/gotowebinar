<?php

namespace Slakbal\Gotowebinar\Resources\Registrant;

use Slakbal\Gotowebinar\Resources\Timezone;
use Slakbal\Gotowebinar\Resources\AbstractResource;

final class Registrant extends AbstractResource
{
    use RegistrantQueryParameters, RegistrantOperations;

    /* CREATE SCHEMA *required
        {
          * "firstName": "string",
          * "lastName": "string",
          * "email": "string",
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

    /** PAYLOAD PROPERTIES */
    protected $firstName;

    protected $lastName;

    protected $email;

    protected $source;

    protected $address;

    protected $city;

    protected $state;

    protected $zipCode;

    protected $country;

    protected $timeZone;

    protected $phone;

    protected $organization;

    protected $jobTitle;

    protected $questionsAndComments;

    protected $industry;

    protected $numberOfEmployees;

    protected $purchasingTimeFrame;

    protected $purchasingRole;

    /** RESOURCE PATH **/
    protected $baseResourcePath = '/organizers/:organizerKey/webinars/:webinarKey/registrants';

    public function __construct()
    {
        $this->resourcePath = $this->baseResourcePath;
    }

    /** OVERRIDES ABSTRACT **/
    protected function requiredFields(): array
    {
        return ['webinarKey', 'firstName', 'lastName', 'email'];
    }

    /** PAYLOAD -- GETTERS AND SETTERS **/
    public function firstName($firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function lastName($lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function email($email): self
    {
        $this->email = $email;

        return $this;
    }

    public function source($source = null): self
    {
        $this->source = $source;

        return $this;
    }

    public function address($address = null): self
    {
        $this->address = $address;

        return $this;
    }

    public function city($city = null): self
    {
        $this->city = $city;

        return $this;
    }

    public function state($state = null): self
    {
        $this->state = $state;

        return $this;
    }

    public function zipCode($zipCode = null): self
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function country($country = null): self
    {
        $this->country = $country;

        return $this;
    }

    public function timeZone($timezone = null): self
    {
        $this->timeZone = (new Timezone($timezone))->getTimezone();

        return $this;
    }

    public function phone($phone = null): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function organization($organization = null): self
    {
        $this->organization = $organization;

        return $this;
    }

    public function jobTitle($jobTitle = null): self
    {
        $this->jobTitle = $jobTitle;

        return $this;
    }

    public function questionsAndComments($questionsAndComments = null): self
    {
        $this->questionsAndComments = $questionsAndComments;

        return $this;
    }

    public function industry($industry = null): self
    {
        $this->industry = $industry;

        return $this;
    }

    public function numberOfEmployees($numberOfEmployees = null): self
    {
        $this->numberOfEmployees = $numberOfEmployees;

        return $this;
    }

    public function purchasingTimeFrame($purchasingTimeFrame = null): self
    {
        $this->purchasingTimeFrame = $purchasingTimeFrame;

        return $this;
    }

    public function purchasingRole($purchasingRole = null): self
    {
        $this->purchasingRole = $purchasingRole;

        return $this;
    }
}
