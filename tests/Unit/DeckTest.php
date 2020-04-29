<?php

namespace Shomisha\Cards\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Shomisha\Cards\Cards\Joker;
use Shomisha\Cards\DeckBuilders\DeckBuilder;
use Shomisha\Cards\Cards\Card;
use Shomisha\Cards\Decks\Deck;
use Shomisha\Cards\Suites\Suite;

class DeckTest extends TestCase
{
    /** @var \Shomisha\Cards\Contracts\DeckBuilder */
    protected $builder;

    public function setUp(): void
    {
        parent::setUp();

        $this->builder = new DeckBuilder();
    }

    /** @test */
    public function deck_cannot_be_instantiated_using_non_card_elements()
    {
        $cards = [
            new Card(Suite::HEARTS(), 13),
            new Joker(),
            'not-a-card'
        ];
        $this->expectException(\InvalidArgumentException::class);

        $deck = new Deck($cards);
    }

    /** @test */
    public function deck_can_return_all_cards()
    {
        $deck = $this->builder->build();

        $cards = $deck->getCards();

        $this->assertCount(54, $cards);
        $this->assertInstanceOf(Card::class, $cards[0]);

        // Assert that the cards will remain in the deck
        $this->assertEquals($cards, $deck->getCards());
    }

    /** @test */
    public function deck_can_override_all_cards()
    {
        $cards = [
            new Card(Suite::HEARTS(), 8),
            new Joker(),
        ];
        $deck = (new DeckBuilder())->build();
        $this->assertCount(54, $deck->getCards());


        $deck->setCards($cards);


        $this->assertCount(2, $deck->getCards());
        $this->assertEquals($cards, $deck->getCards());
    }

    /** @test */
    public function deck_cannot_override_cards_using_non_card_elements()
    {
        $cards = [
            new Joker(),
            'not-a-card',
        ];
        $deck = (new DeckBuilder())->build();
        $this->assertCount(54, $deck->getCards());

        $this->expectException(\InvalidArgumentException::class);


        $deck->setCards($cards);
    }

    /** @test */
    public function deck_can_draw_the_first_card_from_the_stack()
    {
        $deck = $this->builder->build();
        $expectedCard = $deck->getCards()[0];
        $this->assertCount(54, $deck->getCards());


        $actualCard = $deck->draw();


        $this->assertEquals($expectedCard->identifier(), $actualCard->identifier());
        $this->assertCount(53, $deck->getCards());
        $this->assertNotEquals($expectedCard->identifier(), $deck->getCards()[0]);
        foreach ($deck->getCards() as $card) {
            $this->assertNotEquals($expectedCard->identifier(), $card->identifier());
        }
    }

    /** @test */
    public function draw_will_return_null_if_no_cards_are_available()
    {
        $deck = new Deck([]);


        $drawn = $deck->draw();


        $this->assertNull($drawn);
    }

    /** @test */
    public function deck_can_place_a_card_on_top_of_the_stack()
    {
        $deck = $this->builder->build();
        $newCard = new Card(Suite::SPADES(), 10);
        $this->assertCount(54, $deck->getCards());


        $deck->place($newCard);


        $this->assertCount(55, $deck->getCards());
        $this->assertEquals($newCard->identifier(), $deck->getCards()[0]->identifier());
    }

    /**
     * @test
     * @testWith [2]
     *           [24]
     *           [32]
     *           [42]
     */
    public function deck_can_take_a_card_from_a_specified_position($position)
    {
        $deck = $this->builder->build();
        $this->assertCount(54, $deck->getCards());


        $takenCard = $deck->take($position);


        $this->assertCount(53, $deck->getCards());
        $this->assertNotEquals($takenCard->identifier(), $deck->getCards()[$position]->identifier());
        foreach ($deck->getCards() as $card) {
            $this->assertNotEquals($takenCard->identifier(), $card->identifier());
        }
    }

    /** @test */
    public function take_will_return_null_if_the_requested_card_is_not_available()
    {
        $deck = $this->builder->build();


        $taken = $deck->take(55);


        $this->assertNull($taken);
    }

    /**
     * @test
     * @testWith [1]
     *           [4]
     *           [32]
     *           [42]
     */
    public function deck_can_put_a_card_into_a_specified_position($position)
    {
        $deck = $this->builder->build();
        $this->assertCount(54, $deck->getCards());
        $newCard = new Card(Suite::HEARTS(), 7);


        $deck->put($newCard, $position);


        $this->assertCount(55, $deck->getCards());
        $this->assertEquals($newCard->identifier(), $deck->getCards()[$position]->identifier());
    }

    /** @test */
    public function deck_can_be_split_to_two_controlled_decks()
    {
        $deck = (new DeckBuilder())->build();
        $this->assertCount(54, $deck->getCards());
        $splitCard = $deck->peek(20);


        $split = $deck->split(20);


        $this->assertEquals($deck, $split[1]);
        $this->assertEquals($splitCard->identifier(), $split[1]->getCards()[0]->identifier());
        $this->assertCount(34, $deck->getCards());
        $this->assertCount(20, $split[0]->getCards());
    }

    /** @test */
    public function deck_can_be_split_into_two_random_decks()
    {
        $deck = (new DeckBuilder())->build();
        $this->assertCount(54, $deck->getCards());

        $split = $deck->split();

        $this->assertNotCount(54, $deck->getCards());
        $this->assertNotEmpty($deck->getCards());
        $this->assertNotCount(54, $split[0]->getCards());
        $this->assertNotEmpty($split[0]->getCards());
    }

    /** @test */
    public function deck_can_be_joined_using_another_deck()
    {
        $builder = new DeckBuilder();

        $deck1 = $builder->build();
        $this->assertCount(54, $deck1->getCards());

        $deck2 = $builder->build();
        $this->assertCount(54, $deck2->getCards());


        $deck1->join($deck2);

        $this->assertCount(108, $deck1->getCards());
        $this->assertEmpty($deck2->getCards());
    }
}