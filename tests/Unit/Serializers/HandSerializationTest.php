<?php

namespace Shomisha\Cards\Tests\Unit\Serializers;

use PHPUnit\Framework\TestCase;
use Shomisha\Cards\Cards\Card;
use Shomisha\Cards\Cards\Joker;
use Shomisha\Cards\Exceptions\Serialization\InvalidSerializedHand;
use Shomisha\Cards\Game\Boards\StackBoard;
use Shomisha\Cards\Game\Hand;
use Shomisha\Cards\Serializers\Card\ArrayCardSerializer;
use Shomisha\Cards\Serializers\Hand\ArrayHandSerializer;
use Shomisha\Cards\Serializers\Hand\JsonHandSerializer;
use Shomisha\Cards\Suites\Suite;

class HandSerializationTest extends TestCase
{
    protected function getArraySerializer(): ArrayHandSerializer
    {
        return new ArrayHandSerializer(new ArrayCardSerializer());
    }

    protected function getJsonSerializer(): JsonHandSerializer
    {
        return new JsonHandSerializer(new ArrayCardSerializer());
    }

    /** @test */
    public function hand_can_be_serialized_to_array()
    {
        $hand = new Hand([
            $joker = new Joker(),
            $ace = new Card(Suite::SPADES(), 1),
        ]);


        $serializer = $this->getArraySerializer();
        $serialized = $serializer->serialize($hand);


        $this->assertEquals([
            'id' => $hand->getId(),
            'type' => Hand::class,
            'cards' => [
                [
                    'id' => $joker->getId(),
                    'suite' => 'joker',
                    'value' => 15,
                ],
                [
                    'id' => $ace->getId(),
                    'suite' => 'spades',
                    'value' => 1,
                ],
            ]
        ], $serialized);
    }

    /** @test */
    public function hand_can_be_unserialized_from_array()
    {
        $serialized = [
            'id' => 'hand-uuid',
            'type' => Hand::class,
            'cards' => [
                [
                    'id' => 'joker-uuid',
                    'suite' => 'joker',
                    'value' => 15,
                ],
                [
                    'id' => 'ace-uuid',
                    'suite' => 'spades',
                    'value' => 1,
                ],
            ]
        ];


        $serializer = $this->getArraySerializer();
        $hand = $serializer->unserialize($serialized);


        $this->assertInstanceOf(Hand::class, $hand);
        $this->assertEquals('joker-uuid', $hand->getCards()[0]->getId());
        $this->assertEquals('ace-uuid', $hand->getCards()[1]->getId());
    }

    /** @test */
    public function hand_cannot_be_unserialized_from_array_without_id()
    {
        $serialized = [
            'type' => Hand::class,
            'cards' => [
                [
                    'id' => 'joker-uuid',
                    'suite' => 'joker',
                    'value' => 15,
                ],
                [
                    'id' => 'ace-uuid',
                    'suite' => 'spades',
                    'value' => 1,
                ],
            ]
        ];
        $this->expectException(InvalidSerializedHand::class);


        $serializer = $this->getArraySerializer();
        $serializer->unserialize($serialized);
    }

    /** @test */
    public function hand_cannot_be_unserialized_from_array_with_invalid_id()
    {
        $serialized = [
            'id' => 22,
            'type' => Hand::class,
            'cards' => [
                [
                    'id' => 'joker-uuid',
                    'suite' => 'joker',
                    'value' => 15,
                ],
                [
                    'id' => 'ace-uuid',
                    'suite' => 'spades',
                    'value' => 1,
                ],
            ]
        ];
        $this->expectException(InvalidSerializedHand::class);


        $serializer = $this->getArraySerializer();
        $serializer->unserialize($serialized);
    }

    /** @test */
    public function hand_cannot_be_unserialized_from_array_without_type()
    {
        $serialized = [
            'id' => 'hand-uuid',
            'cards' => [
                [
                    'id' => 'joker-uuid',
                    'suite' => 'joker',
                    'value' => 15,
                ],
                [
                    'id' => 'ace-uuid',
                    'suite' => 'spades',
                    'value' => 1,
                ],
            ]
        ];
        $this->expectException(InvalidSerializedHand::class);


        $serializer = $this->getArraySerializer();
        $serializer->unserialize($serialized);
    }

    /** @test */
    public function hand_cannot_be_unserialized_from_array_with_non_existent_type()
    {
        $serialized = [
            'id' => 'hand-uuid',
            'type' => 'invalid-type',
            'cards' => [
                [
                    'id' => 'joker-uuid',
                    'suite' => 'joker',
                    'value' => 15,
                ],
                [
                    'id' => 'ace-uuid',
                    'suite' => 'spades',
                    'value' => 1,
                ],
            ]
        ];
        $this->expectException(InvalidSerializedHand::class);


        $serializer = $this->getArraySerializer();
        $serializer->unserialize($serialized);
    }

    /** @test */
    public function hand_cannot_be_unserialized_from_array_with_non_hand_type()
    {
        $serialized = [
            'id' => 'hand-uuid',
            'type' => StackBoard::class,
            'cards' => [
                [
                    'id' => 'joker-uuid',
                    'suite' => 'joker',
                    'value' => 15,
                ],
                [
                    'id' => 'ace-uuid',
                    'suite' => 'spades',
                    'value' => 1,
                ],
            ]
        ];
        $this->expectException(InvalidSerializedHand::class);


        $serializer = $this->getArraySerializer();
        $serializer->unserialize($serialized);
    }

    /** @test */
    public function hand_cannot_be_unserialized_from_array_without_cards()
    {
        $serialized = [
            'id' => 'hand-uuid',
            'type' => Hand::class,
        ];
        $this->expectException(InvalidSerializedHand::class);


        $serializer = $this->getArraySerializer();
        $serializer->unserialize($serialized);
    }

    /** @test */
    public function hand_cannot_be_unserialized_from_array_with_invalid_cards()
    {
        $serialized = [
            'id' => 'hand-uuid',
            'type' => Hand::class,
            'cards' => 'invalid-cards',
        ];
        $this->expectException(InvalidSerializedHand::class);


        $serializer = $this->getArraySerializer();
        $serializer->unserialize($serialized);
    }

    /** @test */
    public function hand_can_be_serialized_to_json()
    {
        $hand = new Hand([
            $joker = new Joker(),
            $ace = new Card(Suite::SPADES(), 1),
        ]);


        $serializer = $this->getJsonSerializer();
        $serialized = $serializer->serialize($hand);


        $this->assertJson($serialized);

        $jsonData = json_decode($serialized, true);
        $this->assertEquals([
            'id' => $hand->getId(),
            'type' => Hand::class,
            'cards' => [
                [
                    'id' => $joker->getId(),
                    'suite' => 'joker',
                    'value' => 15,
                ],
                [
                    'id' => $ace->getId(),
                    'suite' => 'spades',
                    'value' => 1,
                ],
            ]
        ], $jsonData);
    }

    /** @test */
    public function hand_can_be_unserialized_from_json()
    {
        $json = '{
            "id": "hand-uuid",
            "type": "Shomisha\\\\Cards\\\\Game\\\\Hand",
            "cards": [
                {
                    "id": "joker-uuid",
                    "suite": "joker",
                    "value": 15
                },
                {
                    "id": "ace-uuid",
                    "suite": "spades",
                    "value": 1
                }
            ]        
        }';


        $serializer = $this->getJsonSerializer();
        $hand = $serializer->unserialize($json);


        $this->assertInstanceOf(Hand::class, $hand);
        $this->assertEquals('hand-uuid', $hand->getId());
        $this->assertEquals('joker-uuid', $hand->getCards()[0]->getId());
        $this->assertEquals('ace-uuid', $hand->getCards()[1]->getId());
    }

    /** @test */
    public function hand_cannot_be_unserialized_from_invalid_json()
    {
        $json = '{
            "id": "hand-uuid",
            "type": "Shomisha\\\\Cards\\\\Game\\\\Hand",
            "cards": [
                    "id": "joker-uuid",
                    "suite": "joker",
                    "value": 15
                },
                {
                    "id": "ace-uuid",
                    "suite": "spades",
                    "value": 1
            ]        
        }';
        $this->expectException(InvalidSerializedHand::class);


        $serializer = $this->getJsonSerializer();
        $serializer->unserialize($json);
    }
}