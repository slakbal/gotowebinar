<?php

namespace Slakbal\Gotowebinar\Resources;

trait HasWebinar
{
    public function webinarKey($webinarKey): self
    {
        $this->pathKeys['webinarKey'] = $webinarKey;

        return $this;
    }
}