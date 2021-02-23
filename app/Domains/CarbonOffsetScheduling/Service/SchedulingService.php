<?php

namespace App\Domains\CarbonOffsetScheduling\Service;

class SchedulingService
{
    public function getSchedule(int $scheduleLengthInMonths, \DateTimeImmutable $subscriptionStartDate): array
    {
        if ($scheduleLengthInMonths < 1) {
            return [];
        }

        $scheduleDates = [];
        for ($i = 1; $i <= $scheduleLengthInMonths; $i++) {
            $scheduleDate = $subscriptionStartDate->add(new \DateInterval(sprintf('P%dM', $i)));

            $baseDay = (int) $subscriptionStartDate->format('d');
            $scheduleDay = (int) $scheduleDate->format('d');

            if ($baseDay !== $scheduleDay) {
                $scheduleDate = $scheduleDate->sub(new \DateInterval(sprintf('P%dD', $scheduleDay)));
            }

            $scheduleDates[] = $scheduleDate->format('Y-m-d');
        }

        return $scheduleDates;
    }
}
