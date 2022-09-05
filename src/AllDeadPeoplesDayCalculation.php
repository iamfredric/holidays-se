<?php

namespace Iamfredric\Holidays;

use Carbon\Carbon;
use Carbon\Exceptions\InvalidDateException;
use InvalidArgumentException;

class AllDeadPeoplesDayCalculation
{
    public function __construct(protected int $year)
    {
    }

    public function get(): string
    {
        return $this->toCarbon()->format('m-d');
    }

    public function toCarbon(): Carbon
    {
        if (! $date = Carbon::createFromFormat("Y-m-d", "{$this->year}-10-31")) {
            throw new InvalidArgumentException('The date could not be parsed');
        };

        if (! $date->isSaturday()) {
            $date->endOfWeek()->subDay();
        }

        if ($date->month < 11 && $date->day < 31) {
            $date->addWeek();
        }

        return $date;
    }
}
