<?php

it('knows when all dead peoples day enters', function ($year, $expectation) {
    expect((new \Iamfredric\Holidays\AllDeadPeoplesDayCalculation($year))->get())
        ->toBe($expectation);
})->with([
    [2022, '11-05'],
    [2018, '11-03'],
    [2001, '11-03'],
    [2013, '11-02'],
    [2008, '11-01'],
    [2020, '10-31']
]);

it('can serve you an carbon instance', function () {
    expect((new \Iamfredric\Holidays\MidsummerCalculation(2022))->toCarbon())
        ->toBeInstanceOf(\Carbon\Carbon::class);
});