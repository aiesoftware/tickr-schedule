<?php

namespace App\Http\Controllers;

use App\Domains\CarbonOffsetScheduling\Command\GetScheduleCommand;
use App\Domains\CarbonOffsetScheduling\Service\SchedulingService;
use Illuminate\Http\Request;

class CarbonOffsetScheduleController
{
    public function getCarbonOffsetSchedule(Request $request, SchedulingService $service)
    {
        $command = new GetScheduleCommand(
            new \DateTimeImmutable($request->query->get('subscriptionStartDate')),
            (int) $request->query->get('scheduleInMonths')
        );

        $schedule = $service->getSchedule($command);

        return response()->json($schedule->scheduleItems);
    }
}
