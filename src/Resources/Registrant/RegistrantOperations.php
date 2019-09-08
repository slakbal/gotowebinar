<?php

namespace Slakbal\Gotowebinar\Resources\Registrant;

trait RegistrantOperations
{
    public function webinarKey($webinarKey): self
    {
        $this->pathKeys['webinarKey'] = $webinarKey;

        return $this;
    }

    /**
     * Set the registrant key and path.
     */
    public function registrantKey($registrantKey): self
    {
        $this->resourcePath = $this->baseResourcePath.'/:registrantKey';

        $this->pathKeys['registrantKey'] = $registrantKey;

        return $this;
    }
}
