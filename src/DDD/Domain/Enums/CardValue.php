<?php

namespace App\DDD\Domain\Enums;

enum CardValue
{
    case VALUE_1;
    case VALUE_2;
    case VALUE_3;
    case VALUE_4;
    case VALUE_5;
    case VALUE_6;
    case VALUE_7;
    case VALUE_8;
    case VALUE_9;
    case VALUE_10;
    case VALUE_11;
    case VALUE_12;
    case VALUE_13;

    public function name(): string
    {
        return match($this)
        {
            self::VALUE_1 => 'As',
            self::VALUE_2 => '2',
            self::VALUE_3 => '3',
            self::VALUE_4 => '4',
            self::VALUE_5 => '5',
            self::VALUE_6 => '6',
            self::VALUE_7 => '7',
            self::VALUE_8 => '8',
            self::VALUE_9 => '9',
            self::VALUE_10 => '10',
            self::VALUE_11 => 'Valet',
            self::VALUE_12 => 'Dame',
            self::VALUE_13 => 'Roi',
        };
    }

    public function value(): int
    {
        return match($this)
        {
            self::VALUE_1 => 1,
            self::VALUE_2 => 2,
            self::VALUE_3 => 3,
            self::VALUE_4 => 4,
            self::VALUE_5 => 5,
            self::VALUE_6 => 6,
            self::VALUE_7 => 7,
            self::VALUE_8 => 8,
            self::VALUE_9 => 9,
            self::VALUE_10 => 10,
            self::VALUE_11 => 11,
            self::VALUE_12 => 12,
            self::VALUE_13 => 13,
        };
    }

    public static function fromValue(int $value): self
    {
        return match($value)
        {
            1 => self::VALUE_1,
            2 => self::VALUE_2,
            3 => self::VALUE_3,
            4 => self::VALUE_4,
            5 => self::VALUE_5,
            6 => self::VALUE_6,
            7 => self::VALUE_7,
            8 => self::VALUE_8,
            9 => self::VALUE_9,
            10 => self::VALUE_10,
            11 => self::VALUE_11,
            12 => self::VALUE_12,
            13 => self::VALUE_13,
        };
    }
}
