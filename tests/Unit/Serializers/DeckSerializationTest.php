<?php

namespace Shomisha\Cards\Tests\Unit\Serializers;

use PHPUnit\Framework\TestCase;
use Shomisha\Cards\DeckBuilders\DeckBuilder;
use Shomisha\Cards\Decks\Deck;
use Shomisha\Cards\Exceptions\Serialization\InvalidSerializedCard;
use Shomisha\Cards\Exceptions\Serialization\InvalidSerializedDeck;
use Shomisha\Cards\Serializers\Card\ArrayCardSerializer;
use Shomisha\Cards\Serializers\Deck\ArrayDeckSerializer;
use Shomisha\Cards\Serializers\Deck\JsonDeckSerializer;

class DeckSerializationTest extends TestCase
{
    protected function getArraySerializer(): ArrayDeckSerializer
    {
        return new ArrayDeckSerializer(new ArrayCardSerializer());
    }

    protected function getJsonSerializer(): JsonDeckSerializer
    {
        return new JsonDeckSerializer(new ArrayCardSerializer());
    }

    /** @test */
    public function decks_can_be_serialized_to_arrays()
    {
        $serializer = $this->getArraySerializer();
        $deck = (new DeckBuilder())->build();


        $serializedDeck = $serializer->serialize($deck);


        $this->assertIsArray($serializedDeck);
        $this->assertEquals($deck->getId(), $serializedDeck['id']);

        $this->assertArrayHasKey('cards', $serializedDeck);
        $this->assertCount(54, $serializedDeck['cards']);
        $this->assertEquals([
            'id' => $deck->peek(0)->getId(),
            'suite' => 'clubs',
            'value' => 1
        ], $serializedDeck['cards'][0]);
    }

    /** @test */
    public function decks_can_be_unserialized_from_arrays()
    {
        $serializedDeck = [
            'id' => 'some-uuid',
            'cards' => [
                [
                    'id' => 'card-1-id',
                    'suite' => 'clubs',
                    'value' => 1,
                ],
                [
                    'id' => 'card-2-id',
                    'suite' => 'clubs',
                    'value' => 2,
                ],
                [
                    'id' => 'card-3-id',
                    'suite' => 'clubs',
                    'value' => 3,
                ],
            ],
        ];
        $serializer = $this->getArraySerializer();


        $unserializedDeck = $serializer->unserialize($serializedDeck);


        $this->assertInstanceOf(Deck::class, $unserializedDeck);
        $this->assertEquals('some-uuid', $unserializedDeck->getId());

        $unserializedCards = $unserializedDeck->getCards();
        $this->assertCount(3, $unserializedCards);
        $this->assertEquals('clubs-1', $unserializedCards[0]->identifier());
    }

    /** @test */
    public function invalidly_serialized_decks_cannot_be_unserialized()
    {
        $serializedDeck = [
            'no-cards' => [
                'value' => 1,
                'suite' => 'clubs',
            ]
        ];
        $this->expectException(InvalidSerializedDeck::class);
        $serializer = $this->getArraySerializer();


        $serializer->unserialize($serializedDeck);
    }

    /** @test */
    public function serialized_decks_with_invalidly_serialized_cards_cannot_be_unserialized()
    {
        $serializedDeck = [
            'id' => 'deck-uuid',
            'cards' => [
                [
                    'value' => 1,
                    'suite' => 'clubs',
                ],
                [
                    'value' => 19,
                    'suite' => 'invalid-suite',
                ]
            ],
        ];
        $this->expectException(InvalidSerializedCard::class);
        $serializer = $this->getArraySerializer();


        $serializer->unserialize($serializedDeck);
    }

    /** @test */
    public function decks_can_be_serialized_to_json()
    {
        $serializer = $this->getJsonSerializer();
        $deck = (new DeckBuilder())->build();


        $serializedDeck = $serializer->serialize($deck);


        $this->assertJson($serializedDeck);

        $jsonData = json_decode($serializedDeck, true);
        $this->assertEquals($deck->getId(), $jsonData['id']);

        $this->assertArrayHasKey('cards', $jsonData);
        $this->assertEquals([
            'id' => $deck->peek(0)->getId(),
            'suite' => 'clubs',
            'value' => 1
        ], $jsonData['cards'][0]);
    }

    /** @test */
    public function decks_can_be_unserialized_from_json()
    {
        $serializedDeck = '{
            "id": "deck-uuid",
            "cards": [
                {
                    "id": "card-1-uuid",
                    "suite": "clubs",
                    "value": 1
                },
                {
                    "id": "card-2-uuid",
                    "suite": "clubs",
                    "value": 2
                },
                {
                    "id": "card-3-uuid",
                    "suite": "clubs",
                    "value": 3
                }
            ]        
        }';
        $serializer = $this->getJsonSerializer();


        $unserializedDeck = $serializer->unserialize($serializedDeck);


        $this->assertInstanceOf(Deck::class, $unserializedDeck);
        $this->assertEquals('deck-uuid', $unserializedDeck->getId());
        $this->assertCount(3, $unserializedDeck->getCards());
    }

    /** @test */
    public function invalid_jsons_cannot_be_unserialized_to_decks()
    {
        $invalidJson = '
            {
                "cards": [
                    {
                        "suite": "clubs",
                        "value": 1                     
                    },
                    {
                        "suite": "clubs",
                        "value": 2,                    
                    },
                ]        
        ';
        $serializer = $this->getJsonSerializer();
        $this->expectException(InvalidSerializedDeck::class);


        $unserialized = $serializer->unserialize($invalidJson);
    }
}