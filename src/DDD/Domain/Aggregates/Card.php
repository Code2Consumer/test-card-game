<?php

namespace App\DDD\Domain\Aggregates;

use App\DDD\Domain\Enums\CardColor;
use App\DDD\Domain\Enums\CardValue;
use App\DDD\Domain\Exceptions\WrongCardColorException;
use App\DDD\Domain\Exceptions\WrongCardValueException;

class Card
{
    private function __construct(
        private int $id,
        private CardColor $color,
        private CardValue $value,
    ) {
    }

    /**
     * @param int $id
     * @param string $color
     * @param int $value
     * @return self
     * @throws WrongCardColorException
     * @throws WrongCardValueException
     */
    public static function create(
        int $id,
        string $color,
        int $value,
    ): self
    {
        if (!in_array($color, array_map(fn(CardColor $color) => $color->name(), CardColor::cases()))) {
            throw new WrongCardColorException();
        }

        if (!in_array($value, array_map(fn(CardValue $value) => $value->value(), CardValue::cases()))) {
            throw new WrongCardValueException();
        }

        return new self(
            $id,
            CardColor::fromName($color),
            CardValue::fromValue($value),
        );
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return CardColor
     */
    public function getColor(): CardColor
    {
        return $this->color;
    }

    /**
     * @return CardValue
     */
    public function getValue(): CardValue
    {
        return $this->value;
    }
}