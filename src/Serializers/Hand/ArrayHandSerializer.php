<?php

namespace Shomisha\Cards\Serializers\Hand;

use Shomisha\Cards\Contracts\Game\Hand;
use Shomisha\Cards\Contracts\Serializers\HandSerializer;
use Shomisha\Cards\Exceptions\Serialization\InvalidSerializedHand;
use Shomisha\Cards\Serializers\Card\ArrayCardSerializer;

class ArrayHandSerializer implements HandSerializer
{
    /** @var \Shomisha\Cards\Serializers\Card\ArrayCardSerializer  */
    private $cardSerializer;

    public function __construct(ArrayCardSerializer $cardSerializer)
    {
        $this->cardSerializer = $cardSerializer;
    }

    public function serialize(Hand $hand)
    {
        $type = get_class($hand);
        $id = $hand->getId();

        $cards = [];

        foreach ($hand->getCards() as $name => $card) {
            $cards[$name] = $this->cardSerializer->serialize($card);
        }

        return [
            'id' => $id,
            'type' => $type,
            'cards' => $cards,
        ];
    }

    public function unserialize($serialized): Hand
    {
        $this->validateSerialized($serialized);

        $cards = [];
        foreach ($serialized['cards'] as $name => $card) {
            $cards[$name] = $this->cardSerializer->unserialize($card);
        }

        /** @var \Shomisha\Cards\Contracts\Game\Hand $hand */
        $hand = new $serialized['type'];
        $hand->setId($serialized['id']);

        $hand->setCards($cards);

        return $hand;
    }

    protected function validateSerialized(array $serialized)
    {
        if (!array_key_exists('id', $serialized)) {
            throw InvalidSerializedHand::missingIdKey();
        }

        if (!is_string($serialized['id'])) {
            throw InvalidSerializedHand::idNotString();
        }

        if (!array_key_exists('type', $serialized)) {
            throw InvalidSerializedHand::missingTypeKey();
        }

        if (!class_exists($serialized['type'])) {
            throw InvalidSerializedHand::typeDoesNotExist();
        }

        if (!in_array(Hand::class, class_implements($serialized['type']))) {
            throw InvalidSerializedHand::typeIsNotHand();
        }

        if (!array_key_exists('cards', $serialized)) {
            throw InvalidSerializedHand::missingCards();
        }

        if (!is_array($serialized['cards'])) {
            throw InvalidSerializedHand::cardsNotAnArray();
        }
    }
}