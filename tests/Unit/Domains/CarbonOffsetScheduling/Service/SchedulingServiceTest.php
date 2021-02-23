<?php

namespace Tests\Unit\Domains\CarbonOffsetScheduling\Service;

use App\Domains\CarbonOffsetScheduling\Service\SchedulingService;
use PHPUnit\Framework\TestCase;

class SchedulingServiceTest extends TestCase
{
    public function testGetSchedule(): void
    {
        $sut = new SchedulingService();

        $schedule = $sut->getSchedule(0, new \DateTimeImmutable());
        $this->assertEquals([], $schedule, 'Returns empty schedule when GetScheduleCommand.scheduleLengthInMonths = 0');

        $schedule = $sut->getSchedule(-1, new \DateTimeImmutable());
        $this->assertEquals([], $schedule, 'Returns empty schedule when GetScheduleCommand.scheduleLengthInMonths < 0');

        $schedule = $sut->getSchedule(5, new \DateTimeImmutable('2021-01-07'));
        $this->assertEquals(['2021-02-07', '2021-03-07', '2021-04-07', '2021-05-07', '2021-06-07'], $schedule, 'Determines a schedule');

        $schedule = $sut->getSchedule(2, new \DateTimeImmutable('1998-01-07'));
        $this->assertEquals(['1998-02-07', '1998-03-07'], $schedule, 'Determines a schedule');

        $schedule = $sut->getSchedule(3, new \DateTimeImmutable('2020-01-30'));
        $this->assertEquals(['2020-02-29', '2020-03-30', '2020-04-30'], $schedule, 'Determines a schedule');

        $schedule = $sut->getSchedule(1, new \DateTimeImmutable('2020-01-31'));
        $this->assertEquals(['2020-02-29'], $schedule, 'Determines a schedule');

        $schedule = $sut->getSchedule(0, new \DateTimeImmutable('2020-01-10'));
        $this->assertEquals([], $schedule, 'Determines a schedule');
    }
}
