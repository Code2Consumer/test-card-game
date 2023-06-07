<?php

namespace App\Command;

use App\DDD\Application\Actions\DrawRandomCards;
use App\DDD\Application\Actions\SortCards;
use App\DDD\Application\Actions\SortCardsTest;
use App\DDD\Domain\Aggregates\CardDeck;
use App\DDD\Domain\Sorters\SortByColor;
use App\DDD\Domain\Sorters\SortByValue;
use App\DDD\Domain\Services\CardService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'CartGame',
    description: 'Creates a deck of cards and sorts it.',
)]
class CartGameCommand extends Command
{
    const SORT_BY_VALUE = 'value';
    const SORT_BY_COLOR = 'color';

    const SORT_TYPES = [
        self::SORT_BY_VALUE,
        self::SORT_BY_COLOR,
    ];

    private CardService $cardService;

    public function __construct(CardService $cardService)
    {
        parent::__construct();
        $this->cardService = $cardService;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('sortBy', InputArgument::OPTIONAL, 'By what info the deck should be sorted. (color or value)')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws \App\DDD\Domain\Exceptions\DeckIsEmptyException
     * @throws \App\DDD\Domain\Exceptions\WrongCardColorException
     * @throws \App\DDD\Domain\Exceptions\WrongCardValueException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output); // Load SymfonyStyle

        $sortBy = $input->getArgument('sortBy') ?? self::SORT_BY_COLOR; // get sortBy argument
        if (!in_array($sortBy, self::SORT_TYPES)) { // check if the value of the argument is good
            $io->error('The sortBy argument is not valid.');
            return Command::FAILURE;
        }

        [$randomCardsDeck, $cardDeck] = (new DrawRandomCards($this->cardService))->handle($this->cardService->createNewDeck(),10);
        // draw 10 random card from a fresh new deck then sort the picked up cards and the rest of the cards in two separeted decks

        $sorter = $sortBy === self::SORT_BY_VALUE ? new SortByValue() : new SortByColor(); // instantiate the sorter
        $sortedDeck                   = (new SortCards($this->cardService, $sorter))->handle($randomCardsDeck);
        // sort the randomly picked cars by passing the sorter we want

        $io->info("A magician approaches ... ");
        sleep(2);

        $io->info("He is holding a deck ... ");
        sleep(2);

        $io->info("He draws 10 cards !");
        sleep(2);
        $io->info("Wait ! He is sorting them now !");

        sleep(3);
        $io->info("I think he wants you to look at them.");
        sleep(2);
        $this->displayDeckAsTable($output, $sortedDeck);

        sleep(3);
        $io->info("Now he wants you to look at the rest of the cards.");
        sleep(2);
        $this->displayDeckAsTable($output, $cardDeck);

        $io->success("He leaves without saying a word.");

        return Command::SUCCESS;
    }

    /**
     * @param OutputInterface $output
     * @param CardDeck $deck
     * @return void
     */
    private function displayDeckAsTable(OutputInterface $output, CardDeck $deck): void
    {
        $tableRows = [];
        foreach ($deck->getCards() as $card)
        {
            $tableRows[] = [$card->getColor()->name(), $card->getValue()->value()];
        }

        $table = new Table($output);
        $table
            ->setHeaders(['color', 'value'])
            ->setRows($tableRows)
        ;
        $table->render();
    }
}
