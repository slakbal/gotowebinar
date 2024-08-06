<?php

namespace Slakbal\Gotowebinar\Http\Integrations\GotoWebinar\Enums;

enum WebinarExperience: string
{
    //Specifies the experience type. The possible values are 'CLASSIC', 'BROADCAST' and 'SIMULIVE'.
    case CLASSIC = 'CLASSIC';
    case BROADCAST = 'BROADCAST';
    case SIMULIVE = 'SIMULIVE';
}
