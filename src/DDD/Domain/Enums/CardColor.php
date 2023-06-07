<?php

namespace App\DDD\Domain\Enums;

enum CardColor
{
    case COLOR_DIAMOND;
    case COLOR_HEART;
    case COLOR_SPADE;
    case COLOR_CLUB;

    public function name(): string
    {
        return match($this)
        {
            self::COLOR_DIAMOND => 'diamond',
            self::COLOR_HEART => 'heart',
            self::COLOR_SPADE => 'spade',
            self::COLOR_CLUB => 'club',
        };
    }

    public static function fromName(string $name): self
    {
        return match($name)
        {
            'diamond' => self::COLOR_DIAMOND,
            'heart' => self::COLOR_HEART,
            'spade' => self::COLOR_SPADE,
            'club' => self::COLOR_CLUB,
        };
    }
}
