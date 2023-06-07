<?php

namespace App\DDD\Application\Actions;

use App\DDD\Domain\Aggregates\CardDeck;
use App\DDD\Domain\Interfaces\CardServiceInterface;
use App\DDD\Domain\Interfaces\SorterInterface;

class SortCards
{
    public function __construct(
        private CardServiceInterface $cardService,
        private SorterInterface      $sorter
    ) {
    }

    /**
     * @param CardDeck $cardDeck
     * @return CardDeck
     * @throws \App\DDD\Domain\Exceptions\DeckIsEmptyException
     */
    public function handle(CardDeck $cardDeck): CardDeck
    {
        return $this->cardService->sortDeck($this->sorter, $cardDeck);
    }
}