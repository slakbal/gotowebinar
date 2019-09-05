<?php

namespace Slakbal\Gotowebinar\Traits;

use Slakbal\Gotowebinar\Client\GotoClient;

trait Actions
{
    use RequestHelpers;

    public function dump(array $data = [])
    {
        //set all the properties of the parent
        $this->setDataByMethod($data);

        //create the payload - the client will extract the payload
        print_r('Payload:');
        dump($this->toArray());

        //Show the exclusions
        print_r('Payload Exclusions:');
        dump($this->getPayloadExclusions());

        //create the query parameters - the client will extract the query parameters
        print_r('Query Parameters:');
        dump($this->queryParameters);

        //build the path for the resource - the client can do this
        print_r('Full Path:');
        dump($this->getResourceFullPath());

        //show keys for path replacement
        print_r('Path Keys:');
        dump($this->pathKeys);
    }

    public function create(array $data = [])
    {
        //set all the properties of the parent
        $this->setDataByMethod($data);

        //validate if the required fields are set
        $this->validate($this->requiredFields());

        return (new GotoClient())->setPath($this->getResourceFullPath())
                                 ->setPathKeys($this->pathKeys)
                                 ->setParameters($this->queryParameters)
                                 ->setPayload($this->getPayload())
                                 ->create();
    }

    public function update(array $data = [])
    {
        //set all the properties of the parent
        $this->setDataByMethod($data);

        return (new GotoClient())->setPath($this->getResourceFullPath())
                                 ->setPathKeys($this->pathKeys)
                                 ->setParameters($this->queryParameters)
                                 ->setPayload($this->getPayload())
                                 ->update();
    }

    public function get()
    {
        return (new GotoClient())->setPath($this->getResourceFullPath())
                                 ->setPathKeys($this->pathKeys)
                                 ->setParameters($this->queryParameters)
                                 ->setPayload($this->getPayload())
                                 ->get();
    }

    public function delete()
    {
        return (new GotoClient())->setPath($this->getResourceFullPath())
                                 ->setPathKeys($this->pathKeys)
                                 ->setParameters($this->queryParameters)
                                 ->setPayload($this->getPayload())
                                 ->delete();
    }

    public function status()
    {
        return (new GotoClient())->status();
    }

    public function authenticate()
    {
        return (new GotoClient())->authenticate();
    }

    public function flushAuthentication()
    {
        return (new GotoClient())->flushAuthentication();
    }
}
