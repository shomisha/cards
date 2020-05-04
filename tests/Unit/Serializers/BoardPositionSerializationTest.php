<?php

namespace Shomisha\Cards\Tests\Unit\Serializers;

use PHPUnit\Framework\TestCase;
use Shomisha\Cards\Cards\Card;
use Shomisha\Cards\Cards\Joker;
use Shomisha\Cards\Exceptions\Serialization\InvalidSerializedBoardPosition;
use Shomisha\Cards\Game\BoardPositions\CardBoardPosition;
use Shomisha\Cards\Game\BoardPositions\StackBoardPosition;
use Shomisha\Cards\Serializers\BoardPosition\ArrayBoardPositionSerializer;
use Shomisha\Cards\Serializers\BoardPosition\JsonBoardPositionSerializer;
use Shomisha\Cards\Serializers\Card\ArrayCardSerializer;
use Shomisha\Cards\Suites\Suite;

class BoardPositionSerializationTest extends TestCase
{
    protected function getArraySerializer(): ArrayBoardPositionSerializer
    {
        return new ArrayBoardPositionSerializer(new ArrayCardSerializer());
    }

    protected function getJsonSerializer(): JsonBoardPositionSerializer
    {
        return new JsonBoardPositionSerializer(new ArrayCardSerializer());
    }

    /** @test */
    public function board_position_can_be_serialized_to_array()
    {
        $card = new Joker();
        $position = new CardBoardPosition($card);


        $serializer = $this->getArraySerializer();
        $serialized = $serializer->serialize($position);


        $this->assertEquals([
            'id' => $position->getId(),
            'type' => CardBoardPosition::class,
            'cards' => [
                0 => [
                    'id'    => $card->getId(),
                    'suite' => 'joker',
                    'value' => 15,
                ],
            ],
        ], $serialized);
    }

    /** @test */
    public function board_position_can_be_unserialized_from_array()
    {
        $serialized = [
            'id' => 'some-uuid',
            'type' => CardBoardPosition::class,
            'cards' => [
                0 => [
                    'id' => 'some-uuid',
                    'suite' => Suite::SPADES()->name(),
                    'value' => 1
                ],
            ],
        ];


        $serializer = $this->getArraySerializer();
        $position = $serializer->unserialize($serialized);


        $this->assertInstanceOf(CardBoardPosition::class, $position);
        $this->assertEquals((new Card(Suite::SPADES(), 1))->identifier(), $position->take()->identifier());
    }

    /** @test */
    public function board_position_will_be_unserialized_to_exact_class()
    {
        $serialized = [
            'id' => 'some-uuid',
            'type' => StackBoardPosition::class,
            'cards' => []
        ];


        $serializer = $this->getArraySerializer();
        $position = $serializer->unserialize($serialized);


        $this->assertInstanceOf(StackBoardPosition::class, $position);
    }

    /** @test */
    public function unserialized_board_position_will_retain_card_positions()
    {
        $serialized = [
            'id' => 'some-uuid',
            'type' => StackBoardPosition::class,
            'cards' => [
                'joker' => [
                    'id' => 'another-uuid',
                    'suite' => 'joker',
                    'value' => 15,
                ],
                'queen-of-hearts' => [
                    'id' => 'too-cool-for-an-id',
                    'suite' => 'hearts',
                    'value' => 13,
                ],
            ]
        ];


        $serializer = $this->getArraySerializer();
        $position = $serializer->unserialize($serialized);


        $this->assertInstanceOf(StackBoardPosition::class, $position);
        $this->assertEquals('some-uuid', $position->getId());

        $expectedJoker = (new Joker())->setId('another-uuid');
        $expectedQueen = (new Card(Suite::HEARTS(), 13))->setId('too-cool-for-an-id');
        $this->assertEquals([
            'joker' => $expectedJoker,
            'queen-of-hearts' => $expectedQueen,
        ], $position->getCards());
    }

    /** @test */
    public function board_position_cannot_be_unserialized_without_type()
    {
        $serialized = [
            'cards' => [
                'joker' => [
                    'suite' => 'joker',
                    'value' => 15,
                ],
                'queen-of-hearts' => [
                    'suite' => 'hearts',
                    'value' => 13,
                ],
            ]
        ];
        $this->expectException(InvalidSerializedBoardPosition::class);


        $serializer = $this->getArraySerializer();
        $serializer->unserialize($serialized);
    }

    /** @test */
    public function board_position_cannot_be_unserialized_using_type_that_does_not_exist()
    {
        $serialized = [
            'type' => 'invalid-type',
            'cards' => [
                'joker' => [
                    'suite' => 'joker',
                    'value' => 15,
                ],
                'queen-of-hearts' => [
                    'suite' => 'hearts',
                    'value' => 13,
                ],
            ]
        ];
        $this->expectException(InvalidSerializedBoardPosition::class);


        $serializer = $this->getArraySerializer();
        $serializer->unserialize($serialized);
    }

    /** @test */
    public function board_position_cannot_be_unserialized_using_type_that_does_not_implement_board_position()
    {
        $serialized = [
            'type' => Card::class,
            'cards' => [
                'joker' => [
                    'suite' => 'joker',
                    'value' => 15,
                ],
                'queen-of-hearts' => [
                    'suite' => 'hearts',
                    'value' => 13,
                ],
            ]
        ];
        $this->expectException(InvalidSerializedBoardPosition::class);


        $serializer = $this->getArraySerializer();
        $serializer->unserialize($serialized);
    }

    /** @test */
    public function board_position_cannot_be_unserialized_without_cards()
    {
        $serialized = [
            'type' => StackBoardPosition::class,
        ];
        $this->expectException(InvalidSerializedBoardPosition::class);


        $serializer = $this->getArraySerializer();
        $serializer->unserialize($serialized);
    }

    /** @test */
    public function board_position_cannot_be_unserialized_using_invalid_cards()
    {
        $serialized = [
            'type' => StackBoardPosition::class,
            'cards' => 'not-an-array',
        ];
        $this->expectException(InvalidSerializedBoardPosition::class);


        $serializer = $this->getArraySerializer();
        $serializer->unserialize($serialized);
    }

    /** @test */
    public function board_position_can_be_serialized_to_json()
    {
        $card = new Joker();
        $boardPosition = new CardBoardPosition($card);


        $serializer = $this->getJsonSerializer();
        $serialized = $serializer->serialize($boardPosition);


        $this->assertJson($serialized);
        $jsonData = json_decode($serialized, true);
        $this->assertEquals([
            'id' => $boardPosition->getId(),
            'type' => CardBoardPosition::class,
            'cards' => [
                0 => [
                    'id' => $card->getId(),
                    'suite' => 'joker',
                    'value' => 15,
                ],
            ],
        ], $jsonData);
    }

    /** @test */
    public function board_position_can_be_unserialized_from_json()
    {

    }

    /** @test */
    public function invalid_json_cannot_be_unserialized_to_board_position()
    {

    }
}