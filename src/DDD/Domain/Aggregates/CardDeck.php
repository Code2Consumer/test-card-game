<?php

namespace App\DDD\Domain\Aggregates;

use App\DDD\Domain\Enums\CardColor;
use App\DDD\Domain\Enums\CardValue;
use App\DDD\Domain\Exceptions\CardIsNotInTheDeckException;
use App\DDD\Domain\Exceptions\UserIsNotAllowedToDrawCardsException;

class CardDeck
{
    private function __construct(
        private array $cards = []
    )
    {
    }

    /**
     * @return self
     * @throws \App\DDD\Domain\Exceptions\WrongCardColorException
     * @throws \App\DDD\Domain\Exceptions\WrongCardValueException
     */
    public static function createNew(): self
    {
        $id = 0;
        $cards = [];
        foreach (CardColor::cases() as $color) {
            foreach (CardValue::cases() as $value) {
                $cards[$id] = Card::create($id, $color->name(), $value->value());
                $id++;
            }
        }

        return new self($cards);
    }

    /**
     * @param array $cards
     * @return self
     */
    public static function create(array $cards)
    {
        return new self($cards);
    }

    /**
     * @param int $cardId
     * @return mixed
     * @throws CardIsNotInTheDeckException
     * @throws UserIsNotAllowedToDrawCardsException
     */
    public function drawCardById(int $cardId)
    {
        if (!$this->guardUserIsAllowedToDrawCards()) {
            throw new UserIsNotAllowedToDrawCardsException();
        }

        if (!array_key_exists($cardId, $this->cards)) {
            throw new CardIsNotInTheDeckException();
        }

        $card = $this->cards[$cardId]; // we pick up the card
        unset($this->cards[$cardId]); // and remove it from the original deck

        return $card;
    }

    /**
     * @return mixed
     * @throws CardIsNotInTheDeckException
     * @throws UserIsNotAllowedToDrawCardsException
     */
    public function drawRandomCard()
    {
        return $this->drawCardById(array_rand($this->cards));
    }

    /**
     * @return bool
     */
    public function guardUserIsAllowedToDrawCards(): bool
    {
        return true; // here we would check if the user is a magician for example then throw an error
    }

    /**
     * @return array<Card>
     */
    public function getCards(): array
    {
        return $this->cards;
    }
}