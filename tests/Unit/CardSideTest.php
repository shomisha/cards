<?php

namespace Shomisha\Cards\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Shomisha\Cards\Enums\CardSide;

class CardSideTest extends TestCase
{
    /**
     * @test
     * @testWith ["face-down"]
     *           ["face-up"]
     */
    public function card_can_be_instantiated_from_string($side)
    {
        $cardSide = CardSide::fromString($side);


        $this->assertInstanceOf(CardSide::class, $cardSide);
        $this->assertEquals($side, $cardSide->side());
    }

    /** @test */
    public function card_cannot_be_instantiated_from_invalid_string()
    {
        $invalidSide = 'invalid-side';
        $this->expectException(\InvalidArgumentException::class);

        CardSide::fromString($invalidSide);
    }

    /** @test */
    public function card_can_be_face_up()
    {
        $actualCard = CardSide::FACE_UP();


        $this->assertEquals('face-up', $actualCard->side());
    }

    /** @test */
    public function card_can_be_face_down()
    {
        $actualCard = CardSide::FACE_DOWN();


        $this->assertEquals('face-down', $actualCard->side());
    }
}