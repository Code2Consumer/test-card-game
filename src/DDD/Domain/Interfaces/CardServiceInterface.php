<?php

namespace App\DDD\Domain\Interfaces;

use App\DDD\Domain\Aggregates\CardDeck;

interface CardServiceInterface
{
    public function drawRandomCards(CardDeck $cardDeck, int $amountOfCards = 1): array;
    public function sortDeck(SorterInterface $sorter, CardDeck $cardDeck): CardDeck;
}