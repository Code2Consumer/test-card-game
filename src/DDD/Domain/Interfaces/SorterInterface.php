<?php

namespace App\DDD\Domain\Interfaces;

use App\DDD\Domain\Aggregates\CardDeck;

interface SorterInterface
{
    public function sort(CardDeck $cardDeck): CardDeck;
}