<?php

namespace Shomisha\Cards\Serializers\Deck;

use Shomisha\Cards\Contracts\Deck as DeckContract;
use Shomisha\Cards\Contracts\Serializers\DeckSerializer as DeckSerializerContract;
use Shomisha\Cards\Decks\Deck;
use Shomisha\Cards\Exceptions\Serialization\InvalidSerializedDeck;
use Shomisha\Cards\Serializers\Card\ArrayCardSerializer;

class ArrayDeckSerializer implements DeckSerializerContract
{
    /** @var \Shomisha\Cards\Serializers\Card\ArrayCardSerializer  */
    protected $cardSerializer;

    public function __construct(ArrayCardSerializer $cardSerializer)
    {
        $this->cardSerializer = $cardSerializer;
    }

    /** @return array */
    public function serialize(DeckContract $deck)
    {
        $serialized = [];

        foreach ($deck->getCards() as $card) {
            $serialized[] = $this->cardSerializer->serialize($card);
        }

        $id = $deck->getId();

        return [
            'id' => $id,
            'cards' => $serialized,
        ];
    }

    /** @param array $serialized */
    public function unserialize($serialized): DeckContract
    {
        $this->validateSerialized($serialized);

        $cards = [];

        foreach ($serialized['cards'] as $serializedCard) {
            $cards[] = $this->cardSerializer->unserialize($serializedCard);
        }

        $deck =  new Deck($cards);
        $deck->setId($serialized['id']);

        return $deck;
    }

    protected function validateSerialized(array $serialized)
    {
        if (!array_key_exists('id', $serialized)) {
            throw InvalidSerializedDeck::missingIdKey();
        }

        if (!is_string($serialized['id'])) {
            throw InvalidSerializedDeck::idNotString();
        }

        if (!array_key_exists('cards', $serialized)) {
            throw InvalidSerializedDeck::missingCards();
        }

        if (!is_array($serialized['cards'])) {
            throw InvalidSerializedDeck::cardsNotArray();
        }
    }
}