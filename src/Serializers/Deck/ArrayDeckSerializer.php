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

        return [
            'cards' => $serialized
        ];
    }

    /** @param array $serialized */
    public function unserialize($serialized): DeckContract
    {
        if (!array_key_exists('cards', $serialized)) {
            throw InvalidSerializedDeck::missingCards();
        }

        $cards = [];

        foreach ($serialized['cards'] as $serializedCard) {
            $cards[] = $this->cardSerializer->unserialize($serializedCard);
        }

        return new Deck($cards);
    }
}