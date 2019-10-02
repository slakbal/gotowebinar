<?php

namespace Slakbal\Gotowebinar\Resources\Session;

trait SessionOperations
{
    public function webinarKey($webinarKey): self
    {
        $this->pathKeys['webinarKey'] = $webinarKey;

        return $this;
    }
}
