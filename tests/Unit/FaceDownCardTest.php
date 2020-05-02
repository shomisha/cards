<?php

namespace Shomisha\Cards\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Shomisha\Cards\Cards\Card;
use Shomisha\Cards\Cards\FaceDownCard;
use Shomisha\Cards\Cards\Joker;
use Shomisha\Cards\Suites\Suite;

class FaceDownCardTest extends TestCase
{
    /**
     * @test
     * @testWith ["face-down", true]
     *           ["face-up", false]
     */
    public function card_can_check_if_it_is_hidden($face, $expectedIsHidden)
    {
        $card = new Card(Suite::HEARTS(), 12);


        $faceDownCard = new FaceDownCard($card, $face);
        $actualIsHidden = $faceDownCard->isHidden();


        $this->assertEquals($expectedIsHidden, $actualIsHidden);
    }

    /** @test */
    public function card_will_be_face_down_by_default()
    {
        $card = new Card(Suite::CLUBS(), 12);


        $faceDown = new FaceDownCard($card);


        $this->assertTrue($faceDown->isHidden());
    }

    /** @test */
    public function card_can_be_instantiated_as_face_up()
    {
        $card = new Joker();

        $faceUp = new FaceDownCard($card, FaceDownCard::FACE_UP);


        $this->assertFalse($faceUp->isHidden());
    }

    /** @test */
    public function card_can_be_hidden()
    {
        $card = new Card(Suite::DIAMONDS(), 7);
        $revealedCard = new FaceDownCard($card, FaceDownCard::FACE_UP);
        $this->assertFalse($revealedCard->isHidden());


        $revealedCard->hide();


        $this->assertTrue($revealedCard->isHidden());
    }

    /** @test */
    public function card_can_be_revealed()
    {
        $card = new Card(Suite::HEARTS(), 13);
        $hiddenCard = new FaceDownCard($card, FaceDownCard::FACE_DOWN);
        $this->assertTrue($hiddenCard->isHidden());


        $hiddenCard->reveal();


        $this->assertFalse($hiddenCard->isHidden());
    }

    /** @test */
    public function card_will_not_reveal_its_rank_if_its_hidden()
    {
        $hiddenCard = new FaceDownCard(
            new Card(Suite::SPADES(), 1),
            FaceDownCard::FACE_DOWN
        );


        $hiddenRank = $hiddenCard->rank();


        $this->assertEquals('*', $hiddenRank);
    }

    /** @test */
    public function card_will_reveal_its_rank_if_its_not_hidden()
    {
        $revealedCard = new FaceDownCard(
            new Card(Suite::SPADES(), 1),
            FaceDownCard::FACE_UP
        );


        $actualRank = $revealedCard->rank();


        $this->assertEquals('Ace', $actualRank);
    }

    /** @test */
    public function card_will_not_reveal_its_value_if_its_hidden()
    {
        $hiddenCard = new FaceDownCard(
            new Card(Suite::CLUBS(), 2),
            FaceDownCard::FACE_DOWN
        );


        $hiddenValue = $hiddenCard->value();


        $this->assertEquals('*', $hiddenValue);
    }

    /** @test */
    public function card_will_reveal_its_value_if_its_not_hidden()
    {
        $revealedCard = new FaceDownCard(
            new Card(Suite::CLUBS(), 2),
            FaceDownCard::FACE_UP
        );


        $actualValue = $revealedCard->value();


        $this->assertEquals(2, $actualValue);
    }

    /** @test */
    public function card_will_not_reveal_its_suite_if_its_hidden()
    {
        $hiddenCard = new FaceDownCard(
            new Joker(),
            FaceDownCard::FACE_DOWN
        );


        $hiddenSuite = $hiddenCard->suite();


        $this->assertEquals('*', $hiddenSuite);
    }

    /** @test */
    public function card_will_reveal_its_suite_if_its_not_hidden()
    {
        $revealedCard = new FaceDownCard(
            new Joker(),
            FaceDownCard::FACE_UP
        );


        $actualSuite = $revealedCard->suite();


        $this->assertEquals(Suite::JOKER(), $actualSuite);
    }

    /** @test */
    public function card_will_not_reveal_its_identifier_if_its_hidden()
    {
        $hiddenCard = new FaceDownCard(
            new Card(Suite::DIAMONDS(), 7),
            FaceDownCard::FACE_DOWN
        );


        $hiddenIdentifier = $hiddenCard->identifier();


        $this->assertEquals('*', $hiddenIdentifier);
    }

    /** @test */
    public function card_will_reveal_its_identifier_if_its_not_hidden()
    {
        $revealedCard = new FaceDownCard(
            new Card(Suite::DIAMONDS(), 7),
            FaceDownCard::FACE_UP
        );


        $actualIdentifier = $revealedCard->identifier();


        $this->assertEquals($actualIdentifier, 'diamonds-7');
    }
}