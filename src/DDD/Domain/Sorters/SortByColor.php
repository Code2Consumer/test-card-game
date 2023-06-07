<?php

namespace App\DDD\Domain\Sorters;

use App\DDD\Domain\Aggregates\Card;
use App\DDD\Domain\Aggregates\CardDeck;
use App\DDD\Domain\Exceptions\CardIsNotInTheDeckException;
use App\DDD\Domain\Exceptions\UserIsNotAllowedToDrawCardsException;
use App\DDD\Domain\Interfaces\SorterInterface;

class SortByColor implements SorterInterface
{
    /**
     * @param CardDeck $cardDeck
     * @return CardDeck
     */
    public function sort(CardDeck $cardDeck): CardDeck
    {
        $cards = $cardDeck->getCards();

        usort($cards, function ($card1, $card2) {
            /* @var Card $card1 */
            /* @var Card $card2 */
            return $card1->getColor()->name() <=> $card2->getColor()->name();
        });

        return CardDeck::create($cards);
    }
}