<?php

namespace Tests\Feature;

use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class CarbonOffsetScheduleTest extends TestCase
{
    public function testResponseShape(): void
    {
        $response = $this->get('/carbon-offset-schedule?subscriptionStartDate=2020-01-01&scheduleInMonths=2');
        $this->assertEquals(json_encode(['2020-02-01', '2020-03-01']), $response->content());
    }

    /**
     * @dataProvider innerBoundaryRequests
     */
    public function testInnerBoundaryRequests(string $url, string $outputMessage): void
    {
        $response = $this->get($url);
        $this->assertEquals(Response::HTTP_OK, $response->status(), $outputMessage);
    }

    public function innerBoundaryRequests(): array
    {
        return [
            ['/carbon-offset-schedule?subscriptionStartDate=2020-01-01&scheduleInMonths=0', 'scheduleInMonths accepts value of 0'],
            ['/carbon-offset-schedule?subscriptionStartDate=2020-01-01&scheduleInMonths=36', 'scheduleInMonths accepts value of 36'],
            [sprintf('/carbon-offset-schedule?scheduleInMonths=1&subscriptionStartDate=%s', (new \DateTime('now'))->format('Y-m-d')), 'subscriptionStartDate can be today']
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
            ['/carbon-offset-schedule?subscriptionStartDate=2020-01-01&scheduleInMonths=37', 'The schedule in months must be between 0 and 36', 'scheduleInMonths has maximum allowed value of 36'],
            ['/carbon-offset-schedule?subscriptionStartDate=2020-01-01&scheduleInMonths=37', 'The schedule in months must be between 0 and 36', 'scheduleInMonths has maximum allowed value of 36'],
            ['/carbon-offset-schedule?scheduleInMonths=1&subscriptionStartDate=2020-01-01%2010:00:00', 'Subscription start date format must be YYYY-MM-DD', 'subscriptionStartDate requires format YYYY-MM-DD'],
            ['/carbon-offset-schedule?scheduleInMonths=1&subscriptionStartDate=not-a-date', 'Subscription start date format must be YYYY-MM-DD', 'subscriptionStartDate requires format YYYY-MM-DD'],
            [sprintf('/carbon-offset-schedule?scheduleInMonths=1&subscriptionStartDate=%s', (new \DateTime('tomorrow'))->format('Y-m-d')), 'Subscription start date must be a past or current date', 'subscriptionStartDate cannot be in future']
        ];
    }
}
