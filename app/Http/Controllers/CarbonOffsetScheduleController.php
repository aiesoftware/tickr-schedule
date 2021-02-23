<?php

namespace App\Http\Controllers;

use App\Domains\CarbonOffsetScheduling\Command\GetScheduleCommand;
use App\Domains\CarbonOffsetScheduling\Service\SchedulingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CarbonOffsetScheduleController
{
    public function getCarbonOffsetSchedule(Request $request, SchedulingService $service)
    {
        $validator = Validator::make($request->all(), [
            'scheduleInMonths' => ['required', 'integer', 'between:0,36'],
            'subscriptionStartDate' => ['required']
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $command = new GetScheduleCommand(
            new \DateTimeImmutable($request->query->get('subscriptionStartDate')),
            (int) $request->query->get('scheduleInMonths')
        );

        $schedule = $service->getSchedule($command);

        return response()->json($schedule->scheduleItems);
    }
}
