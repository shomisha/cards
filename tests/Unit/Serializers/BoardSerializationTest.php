<?php

namespace Shomisha\Cards\Tests\Unit\Serializers;

use PHPUnit\Framework\TestCase;
use Shomisha\Cards\Cards\Card;
use Shomisha\Cards\Cards\Joker;
use Shomisha\Cards\Decks\Deck;
use Shomisha\Cards\Exceptions\Serialization\InvalidSerializedBoard;
use Shomisha\Cards\Game\BoardPositions\StackBoardPosition;
use Shomisha\Cards\Game\Boards\StackBoard;
use Shomisha\Cards\Serializers\Board\ArrayBoardSerializer;
use Shomisha\Cards\Serializers\Board\JsonBoardSerializer;
use Shomisha\Cards\Serializers\BoardPosition\ArrayBoardPositionSerializer;
use Shomisha\Cards\Serializers\Card\ArrayCardSerializer;
use Shomisha\Cards\Suites\Suite;

class BoardSerializationTest extends TestCase
{
    protected function getArraySerializer(): ArrayBoardSerializer
    {
        return new ArrayBoardSerializer(new ArrayBoardPositionSerializer(new ArrayCardSerializer()));
    }

    protected function getJsonSerializer(): JsonBoardSerializer
    {
        return new JsonBoardSerializer(new ArrayBoardPositionSerializer(new ArrayCardSerializer()));
    }

    /** @test */
    public function board_can_be_serialized_to_array()
    {
        $board = new StackBoard([
            $joker = new Joker(),
            $jack = new Card(Suite::HEARTS(), 12),
        ]);


        $serializer = $this->getArraySerializer();
        $serialized = $serializer->serialize($board);


        $this->assertEquals([
            'id' => $board->getId(),
            'type' => StackBoard::class,
            'positions' => [
                'stack' => [
                    'id' => $board->getStack()->getId(),
                    'type' => StackBoardPosition::class,
                    'cards' => [
                        [
                            'id' => $joker->getId(),
                            'suite' => 'joker',
                            'value' => 15,
                        ],
                        [
                            'id' => $jack->getId(),
                            'suite' => 'hearts',
                            'value' => 12,
                        ],
                    ],
                ],
            ],
        ], $serialized);
    }

    /** @test */
    public function board_can_be_unserialized_from_array()
    {
        $serialized = [
            'id' => 'board-uuid',
            'type' => StackBoard::class,
            'positions' => [
                'stack' => [
                    'id' => 'board-position-uuid',
                    'type' => StackBoardPosition::class,
                    'cards' => [
                        [
                            'id' => 'joker-uuid',
                            'suite' => 'joker',
                            'value' => 15,
                        ],
                        [
                            'id' => 'jack-uuid',
                            'suite' => 'hearts',
                            'value' => 12,
                        ],
                    ],
                ],
            ],
        ];


        $serializer = $this->getArraySerializer();
        $board = $serializer->unserialize($serialized);


        $this->assertInstanceOf(StackBoard::class, $board);
        $this->assertEquals('board-uuid', $board->getId());

        $stack = $board->getStack();
        $this->assertEquals('joker-uuid', $stack->getCards()[0]->getId());
        $this->assertEquals('jack-uuid', $stack->getCards()[1]->getId());
    }

    /** @test */
    public function serialized_board_position_cannot_be_unserialized_without_id()
    {
        $serialized = [
            'type' => StackBoard::class,
            'positions' => [
                'stack' => [
                    'id' => 'board-position-uuid',
                    'type' => StackBoardPosition::class,
                    'cards' => [
                        [
                            'id' => 'joker-uuid',
                            'suite' => 'joker',
                            'value' => 15,
                        ],
                        [
                            'id' => 'jack-uuid',
                            'suite' => 'hearts',
                            'value' => 12,
                        ],
                    ],
                ],
            ],
        ];
        $this->expectException(InvalidSerializedBoard::class);


        $serializer = $this->getArraySerializer();
        $serializer->unserialize($serialized);
    }

    /** @test */
    public function serialized_board_position_cannot_be_unserialized_with_invalid_id()
    {
        $serialized = [
            'id' => 24,
            'type' => StackBoard::class,
            'positions' => [
                'stack' => [
                    'id' => 'board-position-uuid',
                    'type' => StackBoardPosition::class,
                    'cards' => [
                        [
                            'id' => 'joker-uuid',
                            'suite' => 'joker',
                            'value' => 15,
                        ],
                        [
                            'id' => 'jack-uuid',
                            'suite' => 'hearts',
                            'value' => 12,
                        ],
                    ],
                ],
            ],
        ];
        $this->expectException(InvalidSerializedBoard::class);


        $serializer = $this->getArraySerializer();
        $serializer->unserialize($serialized);
    }

    /** @test */
    public function serialized_board_position_cannot_be_unserialized_without_type()
    {
        $serialized = [
            'id' => 'board-uuid',
            'positions' => [
                'stack' => [
                    'id' => 'board-position-uuid',
                    'type' => StackBoardPosition::class,
                    'cards' => [
                        [
                            'id' => 'joker-uuid',
                            'suite' => 'joker',
                            'value' => 15,
                        ],
                        [
                            'id' => 'jack-uuid',
                            'suite' => 'hearts',
                            'value' => 12,
                        ],
                    ],
                ],
            ],
        ];
        $this->expectException(InvalidSerializedBoard::class);


        $serializer = $this->getArraySerializer();
        $serializer->unserialize($serialized);
    }

    /** @test */
    public function serialized_board_position_cannot_be_unserialized_with_non_existent_type()
    {
        $serialized = [
            'id' => 'board-uuid',
            'type' => 'invalid-type',
            'positions' => [
                'stack' => [
                    'id' => 'board-position-uuid',
                    'type' => StackBoardPosition::class,
                    'cards' => [
                        [
                            'id' => 'joker-uuid',
                            'suite' => 'joker',
                            'value' => 15,
                        ],
                        [
                            'id' => 'jack-uuid',
                            'suite' => 'hearts',
                            'value' => 12,
                        ],
                    ],
                ],
            ],
        ];
        $this->expectException(InvalidSerializedBoard::class);


        $serializer = $this->getArraySerializer();
        $serializer->unserialize($serialized);
    }

    /** @test */
    public function serialized_board_position_cannot_be_unserialized_with_non_board_type()
    {
        $serialized = [
            'id' => 'board-uuid',
            'type' => Deck::class,
            'positions' => [
                'stack' => [
                    'id' => 'board-position-uuid',
                    'type' => StackBoardPosition::class,
                    'cards' => [
                        [
                            'id' => 'joker-uuid',
                            'suite' => 'joker',
                            'value' => 15,
                        ],
                        [
                            'id' => 'jack-uuid',
                            'suite' => 'hearts',
                            'value' => 12,
                        ],
                    ],
                ],
            ],
        ];
        $this->expectException(InvalidSerializedBoard::class);


        $serializer = $this->getArraySerializer();
        $serializer->unserialize($serialized);
    }

    /** @test */
    public function serialized_board_position_cannot_be_unserialized_without_positions()
    {
        $serialized = [
            'id' => 'board-uuid',
            'type' => StackBoard::class,
        ];
        $this->expectException(InvalidSerializedBoard::class);


        $serializer = $this->getArraySerializer();
        $serializer->unserialize($serialized);
    }

    /** @test */
    public function serialized_board_position_cannot_be_unserialized_with_invalid_permissions()
    {
        $serialized = [
            'id' => 'board-uuid',
            'type' => StackBoard::class,
            'positions' => 'invalid-positions'
        ];
        $this->expectException(InvalidSerializedBoard::class);


        $serializer = $this->getArraySerializer();
        $serializer->unserialize($serialized);
    }

    /** @test */
    public function board_can_be_serialized_to_json()
    {
        $board = new StackBoard([
            $joker = new Joker(),
            $jack = new Card(Suite::HEARTS(), 12),
        ]);


        $serializer = $this->getJsonSerializer();
        $serialized = $serializer->serialize($board);


        $this->assertJson($serialized);

        $jsonData = json_decode($serialized, true);
        $this->assertEquals([
            'id' => $board->getId(),
            'type' => StackBoard::class,
            'positions' => [
                'stack' => [
                    'id' => $board->getStack()->getId(),
                    'type' => StackBoardPosition::class,
                    'cards' => [
                        [
                            'id' => $joker->getId(),
                            'suite' => 'joker',
                            'value' => 15,
                        ],
                        [
                            'id' => $jack->getId(),
                            'suite' => 'hearts',
                            'value' => 12,
                        ],
                    ],
                ],
            ],
        ], $jsonData);
    }

    /** @test */
    public function board_can_be_unserialized_from_json()
    {
        $json = '{
            "id": "board-uuid",
            "type": "Shomisha\\\\Cards\\\\Game\\\\Boards\\\\StackBoard",
            "positions": {
                "stack": {
                    "id": "position-uuid",
                    "type": "Shomisha\\\\Cards\\\\Game\\\\BoardPositions\\\\StackBoardPosition",
                    "cards": [
                        {
                            "id": "joker-uuid",
                            "suite": "joker",
                            "value": 15
                        },
                        {
                            "id": "jack-uuid",
                            "suite": "hearts",
                            "value": 12
                        }
                    ]
                }            
            }        
        }';


        $serializer = $this->getJsonSerializer();
        $board = $serializer->unserialize($json);


        $this->assertInstanceOf(StackBoard::class, $board);
        $this->assertEquals('board-uuid', $board->getId());


        $stack = $board->getStack();
        $this->assertEquals('position-uuid', $stack->getId());
        $this->assertEquals('joker-uuid', $stack->getCards()[0]->getId());
        $this->assertEquals('jack-uuid', $stack->getCards()[1]->getId());
    }

    /** @test */
    public function board_cannot_be_unserialized_from_invalid_json()
    {
        $json = '{
            "id": "board-uuid",
            "type": "Shomisha\\\\Cards\\\\Game\\\\Boards\\\\StackBoard",
            "positions": {
                "stack": {
                    "id": "position-uuid",
                    "type": "Shomisha\\\\Cards\\\\Game\\\\BoardPositions\\\\StackBoardPosition",
                    "cards": [
                        {
                            "id": "joker-uuid",
                            "suite": "joker",
                            "value": 15
                        {
                            "id": "jack-uuid",
                            "suite": "hearts",
                            "value": 12
                        },
                    ]
                }            
            }        
        }';
        $this->expectException(InvalidSerializedBoard::class);


        $serializer = $this->getJsonSerializer();
        $serializer->unserialize($json);
    }
}