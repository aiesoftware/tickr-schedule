<?php

namespace Tests\Feature;

use App\Domains\CarbonOffsetScheduling\Command\GetScheduleCommand;
use App\Domains\CarbonOffsetScheduling\Model\Schedule;
use App\Domains\CarbonOffsetScheduling\Service\SchedulingService;
use Symfony\Component\HttpFoundation\Response;
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

    /**
     * @dataProvider innerBoundaryRequests
     */
    public function testInnerRequestBoundaries(string $url, string $outputMessage): void
    {
        $response = $this->get($url);
        $this->assertEquals(Response::HTTP_OK, $response->status(), $outputMessage);
    }

    public function innerBoundaryRequests(): array
    {
        return [
            ['/carbon-offset-schedule?subscriptionStartDate=2020-01-01&scheduleInMonths=0', 'scheduleInMonths accepts value of 0'],
            ['/carbon-offset-schedule?subscriptionStartDate=2020-01-01&scheduleInMonths=36', 'scheduleInMonths accepts value of 36'],
        ];
    }

    /**
     * @dataProvider badRequests
     */
    public function testBadRequests(string $url, string $expectedError, string $outputMessage): void
    {
        $response = $this->get($url);
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->status());
        $this->assertStringContainsString($expectedError, $response->content(), $outputMessage);
    }

    public function badRequests(): array
    {
        return [
            ['/carbon-offset-schedule?scheduleInMonths=1', 'The subscription start date field is required', 'subscriptionStartDate is required'],
            ['/carbon-offset-schedule?subscriptionStartDate=2020-01-01', 'The schedule in months field is required', 'scheduleInMonths is required'],
            ['/carbon-offset-schedule?subscriptionStartDate=2020-01-01&scheduleInMonths=four', 'The schedule in months must be an integer', 'scheduleInMonths requires an int'],
            ['/carbon-offset-schedule?subscriptionStartDate=2020-01-01&scheduleInMonths=4a', 'The schedule in months must be an integer', 'scheduleInMonths requires an int'],
            ['/carbon-offset-schedule?subscriptionStartDate=2020-01-01&scheduleInMonths=-1', 'The schedule in months must be between 0 and 36', 'scheduleInMonths has maximum allowed value of 36'],
            ['/carbon-offset-schedule?subscriptionStartDate=2020-01-01&scheduleInMonths=37', 'The schedule in months must be between 0 and 36', 'scheduleInMonths has maximum allowed value of 36']
        ];
    }
}
