<?php

namespace Shomisha\Cards\Tests\Unit\Game;

use PHPUnit\Framework\TestCase;
use Shomisha\Cards\Cards\Card;
use Shomisha\Cards\Cards\Joker;
use Shomisha\Cards\Game\BoardPositions\CardBoardPosition;
use Shomisha\Cards\Game\BoardPositions\StackBoardPosition;
use Shomisha\Cards\Suites\Suite;

class CardBoardPositionTest extends TestCase
{
    /** @test */
    public function position_can_be_instantiated_empty()
    {
        $position = new CardBoardPosition();


        $this->assertNull($position->take());
    }

    /** @test */
    public function position_can_be_instantiated_with_card()
    {
        $card = new Card(Suite::HEARTS(), 12);
        $position = new CardBoardPosition($card);


        $actualCard = $position->take();


        $this->assertEquals($card, $actualCard);
    }

    /** @test */
    public function position_cannot_be_instantiated_using_non_card_elements()
    {
        $cards = [
            new Joker(),
            'not-a-card',
        ];

        $this->expectException(\InvalidArgumentException::class);


        $position = new StackBoardPosition($cards);
    }

    /** @test */
    public function card_can_be_added_using_setCards_method()
    {
        $position = new CardBoardPosition();
        $this->assertNull($position->take());
        $card = new Joker();


        $position->setCards([$card]);


        $this->assertEquals($card, $position->peek());
    }

    /** @test */
    public function only_one_card_can_be_set()
    {
        $position = new CardBoardPosition();
        $this->assertNull($position->peek());
        $cards = [
            new Joker(),
            new Joker()
        ];

        $this->expectException(\InvalidArgumentException::class);


        $position->setCards($cards);
    }

    /** @test */
    public function card_can_be_returned_as_array()
    {
        $position = new CardBoardPosition($card = new Joker());


        $actualCards = $position->getCards();


        $this->assertEquals($card, $actualCards[0]);
    }

    /** @test */
    public function array_with_null_will_be_returned_if_there_is_no_card()
    {
        $position = new CardBoardPosition();


        $actualCards = $position->getCards();


        $this->assertEquals([null], $actualCards);
    }

    /** @test */
    public function card_can_be_put_on_position()
    {
        $position = new CardBoardPosition();
        $card = new Card(Suite::SPADES(), 7);


        $position->put($card);


        $this->assertEquals($card, $position->peek());
    }

    /** @test */
    public function existing_card_will_be_override_when_putting_a_new_card()
    {
        $position = new CardBoardPosition(new Joker());
        $card = new Card(Suite::DIAMONDS(), 4);


        $position->put($card);


        $this->assertEquals($card, $position->peek());
    }

    /** @test */
    public function user_can_peek_at_position_card()
    {
        $position = new CardBoardPosition($joker = new Joker());


        $actualCard = $position->peek();


        $this->assertEquals($joker, $actualCard);

        // We perform another assertion to ensure
        // peek didn't remove the card from the position
        $this->assertEquals($joker, $position->take());
    }

    /** @test */
    public function user_can_take_the_position_card()
    {
        $position = new CardBoardPosition($joker = new Joker());


        $actualCard = $position->take();


        $this->assertEquals($joker, $actualCard);
        $this->assertNull($position->take());
    }
}