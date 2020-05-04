<?php

namespace Shomisha\Cards\Serializers\BoardPosition;

use Shomisha\Cards\Contracts\Game\BoardPosition;
use Shomisha\Cards\Contracts\Serializers\BoardPositionSerializer;
use Shomisha\Cards\Exceptions\Serialization\InvalidSerializedBoardPosition;
use Shomisha\Cards\Serializers\Card\ArrayCardSerializer;

class ArrayBoardPositionSerializer implements BoardPositionSerializer
{
    /** @var \Shomisha\Cards\Serializers\Card\ArrayCardSerializer  */
    private $cardSerializer;

    public function __construct(ArrayCardSerializer $cardSerializer)
    {
        $this->cardSerializer = $cardSerializer;
    }

    public function serialize(BoardPosition $position)
    {
        $cards = [];

        foreach ($position->getCards() as $name => $card) {
            $cards[$name] = $this->cardSerializer->serialize($card);
        }

        $type = get_class($position);

        return [
            'type' => $type,
            'cards' => $cards,
        ];
    }

    public function unserialize($serialized): BoardPosition
    {
        $this->validateSerialized($serialized);

        $cards = [];
        foreach ($serialized['cards'] as $name => $card) {
            $cards[$name] = $this->cardSerializer->unserialize($card);
        }

        /** @var \Shomisha\Cards\Contracts\Game\BoardPosition $position */
        $position = new $serialized['type'];

        $position->setCards($cards);

        return $position;
    }

    protected function validateSerialized(array $serialized)
    {
        if (!array_key_exists('type', $serialized)) {
            throw InvalidSerializedBoardPosition::missingTypeKey();
        }

        if (!class_exists($serialized['type'])) {
            throw InvalidSerializedBoardPosition::typeDoesNotExist();
        }

        if (!in_array(BoardPosition::class, class_implements($serialized['type']))) {
            throw InvalidSerializedBoardPosition::typeNotBoardPosition();
        }

        if (!array_key_exists('cards', $serialized)) {
            throw InvalidSerializedBoardPosition::missingCardsKey();
        }

        if (!is_array($serialized['cards'])) {
            throw InvalidSerializedBoardPosition::cardsIsNotAnArray();
        }
    }
}