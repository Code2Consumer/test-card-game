<?php

namespace tests\src\DDD\Application\Actions;

use App\DDD\Application\Actions\SortCards;
use App\DDD\Domain\Aggregates\CardDeck;
use App\DDD\Domain\Interfaces\CardServiceInterface;
use App\DDD\Domain\Services\CardService;
use App\DDD\Domain\Sorters\SortByColor;
use App\DDD\Domain\Sorters\SortByValue;
use PHPUnit\Framework\TestCase;

class SortCardsTest extends TestCase
{
    // php vendor/bin/phpunit tests/src/DDD/Application/Actions/SortCardsTest.php

    private CardServiceInterface $cardService;

    protected function setUp(): void
    {
        $this->cardService = new CardService();
    }

    public function testHandleSortByValue()
    {
        $sortedDeck = (new SortCards($this->cardService, new SortByValue()))->handle($this->cardService->createNewDeck());

        $lastCard = null;
        foreach ($sortedDeck->getCards() as $card)
        {
            if (!is_null($lastCard)) {
                $this->assertGreaterThanOrEqual(
                    $lastCard->getValue()->value(),
                    $card->getValue()->value()
                );
            }
            $lastCard = $card;
        }
    }

    public function testHandleSortColor()
    {
        $sortedDeck = (new SortCards($this->cardService, new SortByColor()))->handle(CardDeck::createNew());

        $lastCard = null;
        foreach ($sortedDeck->getCards() as $card)
        {
            if (!is_null($lastCard)) {
                $this->assertGreaterThanOrEqual(
                    $lastCard->getColor()->name(),
                    $card->getColor()->name()
                );
            }
            $lastCard = $card;
        }
    }
}