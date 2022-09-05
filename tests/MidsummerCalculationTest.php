<?php

it('knows when midsummer day enters', function ($year, $expectation) {
    expect((new \Iamfredric\Holidays\MidsummerCalculation($year))->get())
        ->toBe($expectation);
})->with([
    [2022, '06-25'],
    [2018, '06-23'],
    [2001, '06-23'],
    [2013, '06-22'],
    [2008, '06-21']
]);

it('can serve you an carbon instance', function () {
    expect((new \Iamfredric\Holidays\MidsummerCalculation(2022))->toCarbon())
        ->toBeInstanceOf(\Carbon\Carbon::class);
});
