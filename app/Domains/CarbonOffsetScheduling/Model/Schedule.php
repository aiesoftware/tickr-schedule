<?php

namespace App\Domains\CarbonOffsetScheduling\Model;

class Schedule
{
    public array $scheduleItems = [];

    public function __construct(array $scheduleItems)
    {
        // @todo validate format of each string in array
        $this->scheduleItems = $scheduleItems;
    }
}
