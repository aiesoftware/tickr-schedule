<?php

namespace Tests\Unit\Domains\CarbonOffsetScheduling\Service;

use App\Domains\CarbonOffsetScheduling\Command\GetScheduleCommand;
use App\Domains\CarbonOffsetScheduling\Service\SchedulingService;
use PHPUnit\Framework\TestCase;

class SchedulingServiceTest extends TestCase
{
    public function testGetSchedule(): void
    {
        $sut = new SchedulingService();

        $command = new GetScheduleCommand(new \DateTimeImmutable(), 0);
        $schedule = $sut->getSchedule($command);
        $this->assertEquals([], $schedule->scheduleItems, 'Returns empty schedule when GetScheduleCommand.scheduleLengthInMonths = 0');

        $command = new GetScheduleCommand(new \DateTimeImmutable(), -1);
        $schedule = $sut->getSchedule($command);
        $this->assertEquals([], $schedule->scheduleItems, 'Returns empty schedule when GetScheduleCommand.scheduleLengthInMonths < 0');

        $command = new GetScheduleCommand(new \DateTimeImmutable('2021-01-07'), 5);
        $schedule = $sut->getSchedule($command);
        $this->assertEquals(['2021-02-07', '2021-03-07', '2021-04-07', '2021-05-07', '2021-06-07'], $schedule->scheduleItems, 'Determines a schedule');

        $command = new GetScheduleCommand(new \DateTimeImmutable('1998-01-07'), 2);
        $schedule = $sut->getSchedule($command);
        $this->assertEquals(['1998-02-07', '1998-03-07'], $schedule->scheduleItems, 'Determines a schedule');

        $command = new GetScheduleCommand(new \DateTimeImmutable('2020-01-30'), 3);
        $schedule = $sut->getSchedule($command);
        $this->assertEquals(['2020-02-29', '2020-03-30', '2020-04-30'], $schedule->scheduleItems, 'Determines a schedule');

        $command = new GetScheduleCommand(new \DateTimeImmutable('2020-01-31'), 1);
        $schedule = $sut->getSchedule($command);
        $this->assertEquals(['2020-02-29'], $schedule->scheduleItems, 'Determines a schedule');

        $command = new GetScheduleCommand(new \DateTimeImmutable('2020-01-10'), 0);
        $schedule = $sut->getSchedule($command);
        $this->assertEquals([], $schedule->scheduleItems, 'Determines a schedule');
    }
}
