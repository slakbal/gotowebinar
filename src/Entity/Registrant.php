<?php

namespace Slakbal\Gotowebinar\Entity;


class Registrant extends EntityAbstract
{

    /* Model Schema
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
            $this->organization = $parameterArray['organization'] ?? null;
            $this->source = $parameterArray['source'] ?? null;
            $this->address = $parameterArray['address'] ?? null;
            $this->city = $parameterArray['city'] ?? null;
            $this->state = $parameterArray['state'] ?? null;
            $this->zipCode = $parameterArray['zipCode'] ?? null;
            $this->country = $parameterArray['country'] ?? null;
            $this->phone = $parameterArray['phone'] ?? null;
            $this->jobTitle = $parameterArray['jobTitle'] ?? null;
            $this->questionsAndComments = $parameterArray['questionsAndComments'] ?? null;
            $this->industry = $parameterArray['industry'] ?? null;
            $this->numberOfEmployees = $parameterArray['numberOfEmployees'] ?? null;
            $this->purchasingTimeFrame = $parameterArray['purchasingTimeFrame'] ?? null;
            $this->purchasingRole = $parameterArray['purchasingRole'] ?? null;
        }
    }


}