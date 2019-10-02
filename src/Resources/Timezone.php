<?php

namespace Slakbal\Gotowebinar\Resources;

class Timezone
{
    public $allowedTimezones = [
        'Pacific/Tongatapu',
        'Pacific/Fiji',
        'Pacific/Auckland',
        'Asia/Magadan',
        'Asia/Vladivostok',
        'Australia/Hobart',
        'Pacific/Guam',
        'Australia/Sydney',
        'Australia/Brisbane',
        'Australia/Darwin',
        'Australia/Adelaide',
        'Asia/Yakutsk',
        'Asia/Seoul',
        'Asia/Tokyo',
        'Asia/Taipei',
        'Australia/Perth',
        'Asia/Singapore',
        'Asia/Irkutsk',
        'Asia/Shanghai',
        'Asia/Krasnoyarsk',
        'Asia/Bangkok',
        'Asia/Jakarta',
        'Asia/Rangoon',
        'Asia/Colombo',
        'Asia/Dhaka',
        'Asia/Novosibirsk',
        'Asia/Katmandu',
        'Asia/Calcutta',
        'Asia/Karachi',
        'Asia/Yekaterinburg',
        'Asia/Kabul',
        'Asia/Tbilisi',
        'Asia/Muscat',
        'Asia/Tehran',
        'Africa/Nairobi',
        'Europe/Moscow',
        'Asia/Kuwait',
        'Asia/Baghdad',
        'Asia/Jerusalem',
        'Europe/Helsinki',
        'Africa/Harare',
        'Africa/Cairo',
        'Europe/Bucharest',
        'Europe/Athens',
        'Africa/Malabo',
        'Europe/Warsaw',
        'Europe/Brussels',
        'Europe/Prague',
        'Europe/Amsterdam',
        'GMT',
        'Europe/London',
        'Africa/Casablanca',
        'Atlantic/Cape_Verde',
        'Atlantic/Azores',
        'America/Buenos_Aires',
        'America/Sao_Paulo',
        'America/St_Johns',
        'America/Santiago',
        'America/Caracas',
        'America/Halifax',
        'America/Indianapolis',
        'America/New_York',
        'America/Bogota',
        'America/Mexico_City',
        'America/Chicago',
        'America/Denver',
        'America/Phoenix',
        'America/Los_Angeles',
        'America/Anchorage',
        'Pacific/Honolulu',
        'MIT',
    ];

    public $timeZone;

    public function __construct($timeZone)
    {
        if (in_array(strtolower($timeZone), array_map('strtolower', $this->allowedTimezones))) {
            $this->timeZone = $timeZone;
        } else {
            $this->timeZone = null;
        }
    }

    public function getTimezone()
    {
        return $this->timeZone;
    }
}
