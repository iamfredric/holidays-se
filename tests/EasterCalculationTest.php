<?php

use Iamfredric\Holidays\EasterCalculation;

it('knows when easter comes', function ($year, $expectation) {
    expect((new EasterCalculation($year))->get())
        ->toBe($expectation);
})->with([
    [2022, '04-17'],
    [2018, '04-01'],
    [2001, '04-15'],
    [2013, '03-31'],
    [2008, '03-23']
]);

it('can serve you an carbon instance', function () {
    expect((new EasterCalculation(2022))->toCarbon())
        ->toBeInstanceOf(\Carbon\Carbon::class);
});
