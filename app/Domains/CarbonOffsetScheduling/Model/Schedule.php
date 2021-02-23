<?php

namespace App\Domains\CarbonOffsetScheduling\Model;

class Schedule
{
    public array $scheduleItems = [];

    public function __construct(array $scheduleItems)
    {
        foreach ($scheduleItems as $item) {
            if (!preg_match('/\d{4}-\d{2}-\d{2}/', $item)) {
                throw new \InvalidArgumentException(sprintf('Invalid date format given: %s. Requires yyyy-mm-dd', $item));
            }
        }

        $this->scheduleItems = $scheduleItems;
    }
}
