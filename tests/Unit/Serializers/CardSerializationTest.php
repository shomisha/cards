<?php

namespace Shomisha\Cards\Tests\Unit\Serializers;

use PHPUnit\Framework\TestCase;
use Shomisha\Cards\Cards\Card;
use Shomisha\Cards\Cards\Joker;
use Shomisha\Cards\Exceptions\Serialization\InvalidSerializedCard;
use Shomisha\Cards\Serializers\Card\ArrayCardSerializer;
use Shomisha\Cards\Serializers\Card\JsonCardSerializer;
use Shomisha\Cards\Suites\Suite;

class CardSerializationTest extends TestCase
{
    protected function getArraySerializer(): ArrayCardSerializer
    {
        return new ArrayCardSerializer();
    }

    protected function getJsonSerializer(): JsonCardSerializer
    {
        return new JsonCardSerializer();
    }

    /** @test */
    public function cards_can_be_serialized_to_arrays()
    {
        $card = new Card(Suite::HEARTS(), 7);
        $serializer = $this->getArraySerializer();


        $serialized = $serializer->serialize($card);


        $this->assertIsArray($serialized);
        $this->assertEquals([
            'id' => $card->getId(),
            'suite' => 'hearts',
            'value' => 7,
        ], $serialized);
    }

    /** @test */
    public function jokers_can_be_serialized_to_arrays()
    {
        $joker = new Joker();
        $serializer = $this->getArraySerializer();


        $serialized = $serializer->serialize($joker);


        $this->assertIsArray($serialized);
        $this->assertEquals([
            'id' => $joker->getId(),
            'suite' => 'joker',
            'value' => 15
        ], $serialized);
    }

    /** @test */
    public function cards_can_be_unserialized_from_arrays()
    {
        $serialized = [
            'id' => 'some-uuid',
            'suite' => 'hearts',
            'value' => 7,
        ];
        $serializer = $this->getArraySerializer();


        $actualCard = $serializer->unserialize($serialized);


        $this->assertInstanceOf(Card::class, $actualCard);

        $expectedCard = new Card(Suite::HEARTS(), 7);
        $expectedCard->setId('some-uuid');
        $this->assertEquals($expectedCard, $actualCard);
    }

    /** @test */
    public function jokers_can_be_unserialized_from_arrays()
    {
        $serialized = [
            'id' => 'some-uuid',
            'suite' => 'joker',
            'value' => 15
        ];
        $serializer = $this->getArraySerializer();


        $actualJoker = $serializer->unserialize($serialized);


        $this->assertInstanceOf(Joker::class, $actualJoker);

        $expectedJoker = new Joker();
        $expectedJoker->setId('some-uuid');
        $this->assertEquals($expectedJoker, $actualJoker);
    }

    /** @test */
    public function serialized_cards_without_ids_cannot_be_unserialized_to_cards()
    {
        $serialized = [
            'suite' => 'hearts',
            'value' => 7,
        ];
        $this->expectException(InvalidSerializedCard::class);


        $serializer = $this->getArraySerializer();
        $serializer->unserialize($serialized);
    }

    /** @test */
    public function serialized_cards_with_invalid_ids_cannot_be_unserialized_to_cards()
    {
        $serialized = [
            'id' => 7,
            'suite' => 'hearts',
            'value' => 7,
        ];
        $this->expectException(InvalidSerializedCard::class);


        $serializer = $this->getArraySerializer();
        $serializer->unserialize($serialized);
    }

    /** @test */
    public function serialized_cards_without_suites_cannot_be_serialized_to_cards()
    {
        $serialized = [
            'id' => 'card-uuid',
            'value' => 13,
        ];
        $this->expectException(InvalidSerializedCard::class);
        $serializer = $this->getArraySerializer();


        $serializer->unserialize($serialized);
    }

    /** @test */
    public function serialized_cards_with_invalid_suites_cannot_be_unserialized_to_cards()
    {
        $serialized = [
            'id' => 'card-uuid',
            'value' => 13,
            'suite' => 'invalid-suite',
        ];
        $this->expectException(InvalidSerializedCard::class);
        $serializer = $this->getArraySerializer();


        $serializer->unserialize($serialized);
    }

    /** @test */
    public function serialized_cards_without_value_cannot_be_unserialized_to_cards()
    {
        $serialized = [
            'id' => 'card-uuid',
            'suite' => 'hearts',
        ];
        $this->expectException(InvalidSerializedCard::class);
        $serializer = $this->getArraySerializer();


        $serializer->unserialize($serialized);
    }

    /** @test */
    public function serialized_cards_with_invalid_value_cannot_be_unserialized_to_cards()
    {
        $serialized = [
            'id' => 'card-uuid',
            'suite' => 'hearts',
            'value' => 19,
        ];
        $this->expectException(InvalidSerializedCard::class);
        $serializer = $this->getArraySerializer();


        $serializer->unserialize($serialized);
    }

    /** @test */
    public function cards_can_be_serialized_to_json()
    {
        $card = new Card(Suite::HEARTS(), 7);
        $serializer = $this->getJsonSerializer();


        $json = $serializer->serialize($card);


        $this->assertJson($json);

        $jsonData = json_decode($json, true);
        $this->assertEquals([
            'id' => $card->getId(),
            'suite' => 'hearts'
            , 'value' => 7
        ], $jsonData);
    }

    /** @test */
    public function jsons_can_be_unserialized_to_cards()
    {
        $json = '
            {
                "id": "some-uuid",
                "suite": "hearts",
                "value": 7
            }        
        ';
        $serializer = $this->getJsonSerializer();


        $actualCard = $serializer->unserialize($json);


        $this->assertInstanceOf(Card::class, $actualCard);

        $expectedCard = new Card(Suite::HEARTS(), 7);
        $expectedCard->setId('some-uuid');
        $this->assertEquals($expectedCard, $actualCard);
    }

    /** @test */
    public function invalid_jsons_cannot_be_unserialized_to_cards()
    {
        $json = '
            {
                "suite": "hearts",
                "value", 7,            
            },
        ';
        $this->expectException(InvalidSerializedCard::class);
        $serializer = $this->getJsonSerializer();


        $serializer->unserialize($json);
    }
}