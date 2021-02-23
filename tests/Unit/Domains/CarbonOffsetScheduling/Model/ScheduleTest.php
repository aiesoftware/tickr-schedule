<?php

namespace Tests\Unit\Domains\CarbonOffsetScheduling\Model;

use App\Domains\CarbonOffsetScheduling\Model\Schedule;
use PHPUnit\Framework\TestCase;

class ScheduleTest extends TestCase
{
    public function testConstructor(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Schedule(['20-02-03']);
    }
}
