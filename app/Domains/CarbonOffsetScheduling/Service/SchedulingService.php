<?php

namespace App\Domains\CarbonOffsetScheduling\Service;

use App\Domains\CarbonOffsetScheduling\Command\GetScheduleCommand;
use App\Domains\CarbonOffsetScheduling\Model\ScheduleAsList;

class SchedulingService
{
    public function getSchedule(GetScheduleCommand $command): ScheduleAsList
    {
        if ($command->scheduleLengthInMonths < 1) {
            return new ScheduleAsList([]);
        }

        $scheduleDates = [];
        for ($i = 1; $i <= $command->scheduleLengthInMonths; $i++) {
            $scheduleDate = $command->subscriptionStartDate->add(new \DateInterval(sprintf('P%dM', $i)));

            $baseDay = (int) $command->subscriptionStartDate->format('d');
            $scheduleDay = (int) $scheduleDate->format('d');

            if ($baseDay !== $scheduleDay) {
                $scheduleDate = $scheduleDate->sub(new \DateInterval(sprintf('P%dD', $scheduleDay)));
            }

            $scheduleDates[] = $scheduleDate->format('Y-m-d');
        }

        return new ScheduleAsList($scheduleDates);
    }
}
