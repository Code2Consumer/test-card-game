<?php

namespace App\DDD\Domain\Services;

use App\DDD\Domain\Aggregates\CardDeck;
use App\DDD\Domain\Exceptions\CardIsNotInTheDeckException;
use App\DDD\Domain\Exceptions\DeckIsEmptyException;
use App\DDD\Domain\Exceptions\UserIsNotAllowedToDrawCardsException;
use App\DDD\Domain\Exceptions\WrongAmountOfCardsException;
use App\DDD\Domain\Interfaces\CardServiceInterface;
use App\DDD\Domain\Interfaces\SorterInterface;

class CardService implements CardServiceInterface
{
    /**
     * @return CardDeck
     * @throws \App\DDD\Domain\Exceptions\WrongCardColorException
     * @throws \App\DDD\Domain\Exceptions\WrongCardValueException
     */
    public function createNewDeck(): CardDeck
    {
        return CardDeck::createNew();
    }

    /**
     * @param CardDeck $cardDeck
     * @param int $amountOfCards
     * @return array<CardDeck>
     * @throws DeckIsEmptyException
     * @throws WrongAmountOfCardsException
     */
    public function drawRandomCards(CardDeck $cardDeck, int $amountOfCards = 1): array
    {
        if ($amountOfCards < 0 || $amountOfCards > count($cardDeck->getCards())) {
            throw new WrongAmountOfCardsException();
        }

        if ($cardDeck->getCards() <= 0) {
            throw new DeckIsEmptyException();
        }

        $randomCards = [];
        for ($i = 1; $i <= $amountOfCards; $i++) {
            try {
                $randomCards[] = $cardDeck->drawRandomCard();
            } catch (CardIsNotInTheDeckException|UserIsNotAllowedToDrawCardsException $e) {
                // log error
                // stop the program
            }
        }

        return [CardDeck::create($randomCards), $cardDeck];
    }

    /**
     * @param SorterInterface $sorter
     * @param CardDeck $cardDeck
     * @return CardDeck
     * @throws DeckIsEmptyException
     */
    public function sortDeck(SorterInterface $sorter, CardDeck $cardDeck): CardDeck
    {
        if ($cardDeck->getCards() <= 0) {
            throw new DeckIsEmptyException();
        }

        return $sorter->sort($cardDeck);
    }
}