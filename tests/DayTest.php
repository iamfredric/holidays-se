<?php

use Carbon\Carbon;
use Iamfredric\Holidays\Day;

it('knows when a day is red, as in Swedish holiday', function () {
    $redDays = json_decode(file_get_contents(dirname(__FILE__, 1) . '/boilerplate/red-days.json'), JSON_OBJECT_AS_ARRAY);

    $currentDate = Carbon::createFromFormat('Y-m-d', $redDays[0]);
    $endDate = Carbon::createFromFormat('Y-m-d', $redDays[count($redDays) - 1]);

    while ($currentDate->lt($endDate)) {
        $day = new Day(Carbon::parse($currentDate));

        expect($day->isRed())
            ->toBe($currentDate->isSunday() || in_array($currentDate->format('Y-m-d'), $redDays));

        $currentDate->addDay();
    }
});

it('knows what kind of day new years day 2022 is', function () {
    $day = new Day(Carbon::createFromFormat('Y-m-d', '2022-01-01'));

    $this->assertTrue($day->isRed());
    $this->assertTrue($day->isHoliday());
    $this->assertTrue($day->isDayBeforeRedDay());
});

it('knows about valborg 2022', function () {
    $day = new Day(Carbon::createFromFormat('Y-m-d', '2022-04-30'));

    $this->assertFalse($day->isRed());
    $this->assertTrue($day->isHoliday());
    $this->assertTrue($day->isDayBeforeRedDay());
});

it('knows about midsummer 2022', function () {
    $day = new Day(Carbon::createFromFormat('Y-m-d', '2022-06-24'));

    $this->assertFalse($day->isRed());
    $this->assertTrue($day->isHoliday());
    $this->assertTrue($day->isDayBeforeRedDay());
});

it('knows about christmas 2022', function () {
    $day = new Day(Carbon::createFromFormat('Y-m-d', '2022-12-24'));

    $this->assertFalse($day->isRed());
    $this->assertTrue($day->isHoliday());
    $this->assertTrue($day->isDayBeforeRedDay());
    $this->assertFalse($day->isEaster());
});

it('knows about easter 2022', function () {
    $day = new Day(Carbon::createFromFormat('Y-m-d', '2022-04-17'));

    $this->assertTrue($day->isEaster());
});

it('knows about pingst 2022', function () {
    $day = new Day(Carbon::createFromFormat('Y-m-d', '2022-06-05'));

    $this->assertTrue($day->isPingstDay());
});