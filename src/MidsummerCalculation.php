<?php

namespace Iamfredric\Holidays;

use Carbon\Carbon;
use InvalidArgumentException;
use function Couchbase\defaultDecoder;

class MidsummerCalculation
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
        if (! $date = Carbon::createFromFormat("Y-m-d", "{$this->year}-06-20")) {
            throw new InvalidArgumentException('The date could not be parsed');
        }

        if (! $date->isSaturday()) {
            $date->endOfWeek()->subDay();
        }

        if ($date->day < 20) {
            $date->addWeek();
        }

        return $date;
    }
}
