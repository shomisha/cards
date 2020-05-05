<?php

namespace Shomisha\Cards\Tests\Unit\Serializers;

use PHPUnit\Framework\TestCase;
use Shomisha\Cards\Cards\Card;
use Shomisha\Cards\Cards\Joker;
use Shomisha\Cards\Exceptions\Serialization\InvalidSerializedPlayer;
use Shomisha\Cards\Game\Hand;
use Shomisha\Cards\Game\Player;
use Shomisha\Cards\Serializers\Card\ArrayCardSerializer;
use Shomisha\Cards\Serializers\Hand\ArrayHandSerializer;
use Shomisha\Cards\Serializers\Player\ArrayPlayerSerializer;
use Shomisha\Cards\Serializers\Player\JsonPlayerSerializer;
use Shomisha\Cards\Suites\Suite;

class PlayerSerializationTest extends TestCase
{
    protected function getArraySerializer(): ArrayPlayerSerializer
    {
        return new ArrayPlayerSerializer(new ArrayHandSerializer(new ArrayCardSerializer()));
    }

    protected function getJsonSerializer(): JsonPlayerSerializer
    {
        return new JsonPlayerSerializer(new ArrayHandSerializer(new ArrayCardSerializer()));
    }

    /** @test */
    public function player_can_be_serialized_to_array()
    {
        $player = new Player('Misa', $hand = new Hand([
            $joker = new Joker(),
            $two = new Card(Suite::CLUBS(), 2),
        ]));


        $serializer = $this->getArraySerializer();
        $serialized = $serializer->serialize($player);


        $this->assertEquals($player->getId(), $serialized['id']);
        $this->assertEquals('Misa', $serialized['name']);
        $this->assertEquals(Player::class, $serialized['type']);
        $this->assertCount(2, $serialized['hand']['cards']);
    }

    /** @test */
    public function player_can_be_unserialized_from_array()
    {
        $serialized = [
            'id' => 'player-uuid',
            'type' => Player::class,
            'name' => 'Misa',
            'hand' => [
                'id' => 'hand-uuid',
                'type' => Hand::class,
                'cards' => [
                    [
                        'id' => 'joker-uuid',
                        'suite' => 'joker',
                        'value' => 15,
                    ],
                    [
                        'id' => 'two-uuid',
                        'suite' => 'clubs',
                        'value' => 2,
                    ],
                ],
            ],
        ];


        $serializer = $this->getArraySerializer();
        $player = $serializer->unserialize($serialized);


        $this->assertInstanceOf(Player::class, $player);
        $this->assertEquals('player-uuid', $player->getId());
        $this->assertEquals('Misa', $player->name());

        $this->assertEquals('joker-uuid', $player->getHand()->getCards()[0]->getId());
        $this->assertEquals('two-uuid', $player->getHand()->getCards()[1]->getId());
    }

    /** @test */
    public function player_cannot_be_unserialized_from_array_without_id()
    {
        $serialized = [
            'type' => Player::class,
            'name' => 'Misa',
            'hand' => [
                'id' => 'hand-uuid',
                'type' => Hand::class,
                'cards' => [
                    [
                        'id' => 'joker-uuid',
                        'suite' => 'joker',
                        'value' => 15,
                    ],
                    [
                        'id' => 'two-uuid',
                        'suite' => 'clubs',
                        'value' => 2,
                    ],
                ],
            ],
        ];
        $this->expectException(InvalidSerializedPlayer::class);


        $serializer = $this->getArraySerializer();
        $serializer->unserialize($serialized);
    }

    /** @test */
    public function player_cannot_be_unserialized_from_array_with_invalid_id()
    {
        $serialized = [
            'id' => false,
            'type' => Player::class,
            'name' => 'Misa',
            'hand' => [
                'id' => 'hand-uuid',
                'type' => Hand::class,
                'cards' => [
                    [
                        'id' => 'joker-uuid',
                        'suite' => 'joker',
                        'value' => 15,
                    ],
                    [
                        'id' => 'two-uuid',
                        'suite' => 'clubs',
                        'value' => 2,
                    ],
                ],
            ],
        ];
        $this->expectException(InvalidSerializedPlayer::class);


        $serializer = $this->getArraySerializer();
        $serializer->unserialize($serialized);
    }

    /** @test */
    public function player_cannot_be_unserialized_from_array_without_type()
    {
        $serialized = [
            'id' => 'player-uuid',
            'name' => 'Misa',
            'hand' => [
                'id' => 'hand-uuid',
                'type' => Hand::class,
                'cards' => [
                    [
                        'id' => 'joker-uuid',
                        'suite' => 'joker',
                        'value' => 15,
                    ],
                    [
                        'id' => 'two-uuid',
                        'suite' => 'clubs',
                        'value' => 2,
                    ],
                ],
            ],
        ];
        $this->expectException(InvalidSerializedPlayer::class);


        $serializer = $this->getArraySerializer();
        $serializer->unserialize($serialized);
    }

    /** @test */
    public function player_cannot_be_unserialized_from_array_with_non_existent_type()
    {
        $serialized = [
            'id' => 'player-uuid',
            'type' => 'i-dont-exist',
            'name' => 'Misa',
            'hand' => [
                'id' => 'hand-uuid',
                'type' => Hand::class,
                'cards' => [
                    [
                        'id' => 'joker-uuid',
                        'suite' => 'joker',
                        'value' => 15,
                    ],
                    [
                        'id' => 'two-uuid',
                        'suite' => 'clubs',
                        'value' => 2,
                    ],
                ],
            ],
        ];
        $this->expectException(InvalidSerializedPlayer::class);


        $serializer = $this->getArraySerializer();
        $serializer->unserialize($serialized);
    }

    /** @test */
    public function player_cannot_be_unserialized_from_array_with_non_player_type()
    {
        $serialized = [
            'id' => 'player-uuid',
            'type' => Hand::class,
            'name' => 'Misa',
            'hand' => [
                'id' => 'hand-uuid',
                'type' => Hand::class,
                'cards' => [
                    [
                        'id' => 'joker-uuid',
                        'suite' => 'joker',
                        'value' => 15,
                    ],
                    [
                        'id' => 'two-uuid',
                        'suite' => 'clubs',
                        'value' => 2,
                    ],
                ],
            ],
        ];
        $this->expectException(InvalidSerializedPlayer::class);


        $serializer = $this->getArraySerializer();
        $serializer->unserialize($serialized);
    }

    /** @test */
    public function player_cannot_be_unserialized_from_array_without_name()
    {
        $serialized = [
            'id' => 'player-uuid',
            'type' => Player::class,
            'hand' => [
                'id' => 'hand-uuid',
                'type' => Hand::class,
                'cards' => [
                    [
                        'id' => 'joker-uuid',
                        'suite' => 'joker',
                        'value' => 15,
                    ],
                    [
                        'id' => 'two-uuid',
                        'suite' => 'clubs',
                        'value' => 2,
                    ],
                ],
            ],
        ];
        $this->expectException(InvalidSerializedPlayer::class);


        $serializer = $this->getArraySerializer();
        $serializer->unserialize($serialized);
    }

    /** @test */
    public function player_cannot_be_unserialized_from_array_with_invalid_name()
    {
        $serialized = [
            'id' => 'player-uuid',
            'type' => Player::class,
            'name' => 666,
            'hand' => [
                'id' => 'hand-uuid',
                'type' => Hand::class,
                'cards' => [
                    [
                        'id' => 'joker-uuid',
                        'suite' => 'joker',
                        'value' => 15,
                    ],
                    [
                        'id' => 'two-uuid',
                        'suite' => 'clubs',
                        'value' => 2,
                    ],
                ],
            ],
        ];
        $this->expectException(InvalidSerializedPlayer::class);


        $serializer = $this->getArraySerializer();
        $serializer->unserialize($serialized);
    }

    /** @test */
    public function player_cannot_be_unserialized_from_array_without_hand()
    {
        $serialized = [
            'id' => 'player-uuid',
            'type' => Player::class,
            'name' => 'Misa',
        ];
        $this->expectException(InvalidSerializedPlayer::class);


        $serializer = $this->getArraySerializer();
        $serializer->unserialize($serialized);
    }

    /** @test */
    public function player_cannot_be_unserialized_from_array_with_invalid_hand()
    {
        $serialized = [
            'id' => 'player-uuid',
            'type' => Player::class,
            'name' => 'Misa',
            'hand' => 'not-an-array',
        ];
        $this->expectException(InvalidSerializedPlayer::class);


        $serializer = $this->getArraySerializer();
        $serializer->unserialize($serialized);
    }

    /** @test */
    public function player_can_be_serialized_to_json()
    {
        $player = new Player('Misa', $hand = new Hand([
            $joker = new Joker(),
            $two = new Card(Suite::CLUBS(), 2),
        ]));


        $serializer = $this->getJsonSerializer();
        $serialized = $serializer->serialize($player);


        $this->assertJson($serialized);

        $jsonData = json_decode($serialized, true);
        $this->assertEquals($player->getId(), $jsonData['id']);
        $this->assertEquals(Player::class, $jsonData['type']);
        $this->assertEquals('Misa', $jsonData['name']);

        $this->assertEquals($joker->getId(), $jsonData['hand']['cards'][0]['id']);
        $this->assertEquals($two->getId(), $jsonData['hand']['cards'][1]['id']);
    }

    /** @test */
    public function player_can_be_unserialized_from_json()
    {
        $json = '{
            "id": "player-uuid",
            "type": "Shomisha\\\\Cards\\\\Game\\\\Player",
            "name": "Misa",
            "hand":{
                "id": "hand-uuid",
                "type": "Shomisha\\\\Cards\\\\Game\\\\Hand",
                "cards": [
                    {
                        "id": "joker-uuid",
                        "suite" :"joker",
                        "value" :"15"
                    },
                    {
                        "id": "two-uuid",
                        "suite": "clubs",
                        "value": 2
                    }
                ]
            }
        }';


        $serializer = $this->getJsonSerializer();
        $player = $serializer->unserialize($json);

        $this->assertInstanceOf(Player::class, $player);
        $this->assertEquals('player-uuid', $player->getId());
        $this->assertEquals('Misa', $player->name());

        $this->assertEquals('joker-uuid', $player->getHand()->getCards()[0]->getId());
        $this->assertEquals('two-uuid', $player->getHand()->getCards()[1]->getId());
    }

    /** @test */
    public function player_cannot_be_unserialized_from_invalid_json()
    {
        $json = '{
            "id": "player-uuid",
            "type": "Shomisha\\\\Cards\\\\Game\\\\Player",
            "name": "Misa"
            "hand":{
                "id": "hand-uuid",
                "type": "Shomisha\\\\Cards\\\\Game\\\\Hand",
                    {
                        "id": "joker-uuid",
                        "suite" :"joker",
                        "value" :"15"
                    },
                    {
                        "id": "two-uuid",
                        "suite": "clubs",
                        "value": 2
                    }
                ]
            }
        }';
        $this->expectException(InvalidSerializedPlayer::class);


        $serializer = $this->getJsonSerializer();
        $serializer->unserialize($json);
    }
}