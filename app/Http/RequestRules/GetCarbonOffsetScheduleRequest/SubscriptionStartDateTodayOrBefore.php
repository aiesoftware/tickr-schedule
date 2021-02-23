<?php

namespace App\Http\RequestRules\GetCarbonOffsetScheduleRequest;

use Illuminate\Contracts\Validation\Rule;

class SubscriptionStartDateTodayOrBefore implements Rule
{
    public function passes($attribute, $value)
    {
        $date = \DateTime::createFromFormat(\DateTime::ISO8601, sprintf('%sT00:00:00Z', $value));
        $tomorrow = new \DateTime('tomorrow');

        return $date < $tomorrow;
    }

    public function message()
    {
        return 'Subscription start date must be a past or current date';
    }
}
