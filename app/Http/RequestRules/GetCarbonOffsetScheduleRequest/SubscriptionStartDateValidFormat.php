<?php

namespace App\Http\RequestRules\GetCarbonOffsetScheduleRequest;

use Illuminate\Contracts\Validation\Rule;

class SubscriptionStartDateValidFormat implements Rule
{
    public function passes($attribute, $value)
    {
        $date = \DateTime::createFromFormat(\DateTime::ISO8601, sprintf('%sT00:00:00Z', $value));

        return $date instanceof \DateTimeInterface;
    }

    public function message()
    {
        return 'Subscription start date format must be YYYY-MM-DD';
    }
}
