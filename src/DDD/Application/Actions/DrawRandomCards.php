<?php

namespace App\DDD\Application\Actions;

use App\DDD\Domain\Aggregates\CardDeck;
use App\DDD\Domain\Exceptions\WrongAmountOfCardsException;
use App\DDD\Domain\Interfaces\CardServiceInterface;

class DrawRandomCards
{
    public function __construct(
        private CardServiceInterface $cardService
    ) {
    }

    /**
     * @param CardDeck $cardDeck
     * @param int $amountOfCards
     * @return array
     */
    public function handle(CardDeck $cardDeck, int $amountOfCards = 1): array
    {
        return $this->cardService->drawRandomCards($cardDeck, $amountOfCards);
    }
}