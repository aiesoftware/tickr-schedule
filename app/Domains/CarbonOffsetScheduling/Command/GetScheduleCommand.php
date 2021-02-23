<?php

namespace App\Domains\CarbonOffsetScheduling\Command;

class GetScheduleCommand
{
    public \DateTimeImmutable $subscriptionStartDate;
    public int $scheduleLengthInMonths;

    public function __construct(\DateTimeImmutable $subscriptionStartDate, int $scheduleLengthInMonths)
    {
        $this->subscriptionStartDate = $subscriptionStartDate;
        $this->scheduleLengthInMonths = $scheduleLengthInMonths;
    }
}
