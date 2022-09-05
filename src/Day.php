<?php

namespace Iamfredric\Holidays;

use Carbon\Carbon;

class Day
{
    /**
     * @var array|string[]
     */
    protected array $redDays = [
        '01-01',
        '01-06',
        '05-01',
        '06-06',
        '12-25',
        '12-26'
    ];

    /**
     * @var array|string[]
     */
    protected array $holidays = [
        '12-24'
    ];

    public function __construct(
        protected Carbon $date
    ) {
    }

    public function isRed(): bool
    {
        if (in_array($this->date->format('m-d'), $this->redDays)) {
            return true;
        }

        if ($this->longFridayBeforeEaster()) {
            return true;
        }

        if ($this->isEaster()) {
            return true;
        }

        if ($this->isDayAfterEaster()) {
            return true;
        }

        if ($this->isChristWentToSky()) {
            return true;
        }

        if ($this->isPingstDay()) {
            return true;
        }

        if ($this->isMidsummer()) {
            return true;
        }

        if ($this->isAllDeadPeoplesDay()) {
            return true;
        }

        return $this->date->isSunday();
    }

    public function isHoliday(): bool
    {
        if ($this->isRed()) {
            return true;
        }

        if ($this->isDayBeforeMidsummer()) {
            return true;
        }

        if ($this->date->isSaturday()) {
            return true;
        }

        return in_array($this->date->format('m-d'), $this->holidays);
    }

    public function isDayBeforeRedDay(): bool
    {
        return (new Day(Carbon::parse($this->date)->addDay()))->isRed();
    }

    public function isEaster(): bool
    {
        return (new EasterCalculation($this->date->year))
            ->toCarbon()
            ->isSameDay($this->date);
    }

    public function isDayAfterEaster(): bool
    {
        return (new EasterCalculation($this->date->year))
            ->toCarbon()
            ->addDay()
            ->isSameDay($this->date);
    }

    protected function isChristWentToSky(): bool
    {
        return (new EasterCalculation($this->date->year))
            ->toCarbon()
            ->nextWeekday()
            ->addDays(3)
            ->addWeeks(5)
            ->isSameDay($this->date);
    }

    public function isPingstDay(): bool
    {
        return (new EasterCalculation($this->date->year))
            ->toCarbon()
            ->endOfWeek()
            ->addWeeks(7)
            ->isSameDay($this->date);
    }

    protected function isMidsummer(): bool
    {
        return (new MidsummerCalculation($this->date->year))
            ->toCarbon()
            ->isSameDay($this->date);
    }

    protected function isDayBeforeMidsummer(): bool
    {
        return (new MidsummerCalculation($this->date->year))
            ->toCarbon()
            ->subDay()
            ->isSameDay($this->date);
    }

    protected function isAllDeadPeoplesDay(): bool
    {
        return (new AllDeadPeoplesDayCalculation($this->date->year))
            ->toCarbon()
            ->isSameDay($this->date);
    }

    protected function longFridayBeforeEaster(): bool
    {
        return (new EasterCalculation($this->date->year))
            ->toCarbon()
            ->subDays(2)
            ->isSameDay($this->date);
    }

    /**
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        return [
            'date' => $this->date->format('Y-m-d'),
            'red' => $this->isRed(),
            'day_before_red' => $this->isDayBeforeRedDay(),
            'holiday' => $this->isHoliday()
        ];
    }
}
