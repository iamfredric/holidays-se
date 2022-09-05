<?php

namespace Iamfredric\Holidays;

use Carbon\Carbon;

class EasterCalculation
{
    public function __construct(protected int $year)
    {
    }

    public function get(): string
    {
        [$a, $b, $c, $m, $n] = [
            $this->restFrom($this->year, 19),
            $this->restFrom($this->year, 4),
            $this->restFrom($this->year, 7),
            $this->m(),
            $this->n()
        ];

        $d = $this->restFrom($this->multiply($a, 19) + $m, 30);
        $e = $this->restFrom($this->multiply($b, 2) + $this->multiply($c, 4) + $this->multiply($d, 6) + $n, 7);

        $result = 22 + $d + $e;

        if ($result <= 31) {
            $result = str_pad("{$result}", 2, '0', STR_PAD_LEFT);

            return "03-{$result}";
        }

        $result -= 31;

        if ($result === 26) {
            $result -= 7;
        } elseif ($result === 25 && $d === 28 && $e === 6 && $a > 10) {
            $result -= 7;
        }

        $result = str_pad("{$result}", 2, '0', STR_PAD_LEFT);

        return "04-{$result}";
    }

    public function toCarbon(): Carbon
    {
        return Carbon::parse($this->year . '-' .$this->get());
    }

    protected function m(): int
    {
        if ($this->yearIsBetween(1583, 1699)) {
            return 22;
        }

        if ($this->yearIsBetween(1700, 1899)) {
            return 23;
        }

        if ($this->yearIsBetween(1900, 2199)) {
            return 24;
        }

        if ($this->yearIsBetween(2200, 2299)) {
            return 25;
        }

        if ($this->yearIsBetween(2300, 2399)) {
            return 26;
        }

        if ($this->yearIsBetween(2400, 2499)) {
            return 25;
        }

        if ($this->yearIsBetween(2500, 2599)) {
            return 26;
        }

        return 0;
    }

    protected function n(): int
    {
        if ($this->yearIsBetween(1583, 1699)) {
            return 2;
        }

        if ($this->yearIsBetween(1700, 1799)) {
            return 3;
        }

        if ($this->yearIsBetween(1800, 1899)) {
            return 4;
        }

        if ($this->yearIsBetween(1900, 2099)) {
            return 5;
        }

        if ($this->yearIsBetween(2100, 2199)) {
            return 6;
        }

        if ($this->yearIsBetween(2300, 2499)) {
            return 1;
        }

        if ($this->yearIsBetween(2500, 2599)) {
            return 2;
        }

        return 0;
    }

    protected function yearIsBetween(int $from, int $to): bool
    {
        return $this->year >= $from && $this->year <= $to;
    }

    protected function restFrom(int|float $from, int|float $int): int|float
    {
        return abs($from - (floor($from / $int) * $int));
    }

    protected function multiply(float|int $number, float|int $times): float|int
    {
        return $number * $times;
    }
}
