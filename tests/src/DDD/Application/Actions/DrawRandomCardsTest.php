<?php

namespace App\Tests\src\DDD\Application\Actions;

use App\DDD\Application\Actions\DrawRandomCards;
use App\DDD\Domain\Interfaces\CardServiceInterface;
use App\DDD\Domain\Services\CardService;
use PHPUnit\Framework\TestCase;

class DrawRandomCardsTest extends TestCase
{
    // php vendor/bin/phpunit tests/src/DDD/Application/Actions/DrawRandomCardsTest.php

    private CardServiceInterface $cardService;

    protected function setUp(): void
    {
        $this->cardService = new CardService();
    }

    public function testHandleSortByValue()
    {
        $cardDeck = $this->cardService->createNewDeck();
        $cardsCount = count($cardDeck->getCards());
        [$randomCardsDeck, $cardDeck] = (new DrawRandomCards($this->cardService))->handle($cardDeck,10);

        $this->assertEquals($cardsCount, count($randomCardsDeck->getCards()) + count($cardDeck->getCards()));

        foreach ($randomCardsDeck->getCards() as $randomCard) {
            foreach ($cardDeck->getCards() as $deckCard) {
                $this->assertNotEquals(
                    [$randomCard->getColor()->name(), $randomCard->getValue()->value()],
                    [$deckCard->getColor()->name(), $deckCard->getValue()->value()]
                );
            }
        }
    }
}