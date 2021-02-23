<?php

namespace Tests\Feature;

use App\Domains\CarbonOffsetScheduling\Command\GetScheduleCommand;
use App\Domains\CarbonOffsetScheduling\Model\Schedule;
use App\Domains\CarbonOffsetScheduling\Service\SchedulingService;
use Tests\TestCase;

class CarbonOffsetScheduleTest extends TestCase
{
    public function testResponseShape(): void
    {
        $serviceMock = $this->createMock(SchedulingService::class);
        $serviceMock
            ->expects($this->once())
            ->method('getSchedule')
            ->with($this->isInstanceOf(GetScheduleCommand::class))
            ->willReturn(new Schedule(['2020-02-01', '2020-03-01']));

        $this->app->instance(SchedulingService::class, $serviceMock);

        $response = $this->get('/carbon-offset-schedule?subscriptionStartDate=2020-01-01&scheduleInMonths=2');
        $this->assertEquals(json_encode(['2020-02-01', '2020-03-01']), $response->content());
    }
}
