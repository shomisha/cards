<?php

namespace Shomisha\Cards\Serializers\Card;

use Shomisha\Cards\Cards\Card;
use Shomisha\Cards\Cards\Joker;
use Shomisha\Cards\Contracts\Card as CardContract;
use Shomisha\Cards\Contracts\Serializers\CardSerializer as CardSerializerContract;
use Shomisha\Cards\Exceptions\Serialization\InvalidSerializedCard;
use Shomisha\Cards\Suites\Suite;

class ArrayCardSerializer implements CardSerializerContract
{
    /** @return array */
    public function serialize(CardContract $card)
    {
        return [
            'id'    => $card->getId(),
            'suite' => $card->suite()->name(),
            'value' => $card->value(),
        ];
    }

    /** @param array $serialized */
    public function unserialize($serialized): CardContract
    {
        $this->validateSerialized($serialized);

        if ($this->isJoker($serialized)) {
            return $this->unserializeJoker($serialized);
        }

        return $this->unserializeCard($serialized);
    }

    private function validateSerialized(array $serialized)
    {
        if (!array_key_exists('id', $serialized)) {
            throw InvalidSerializedCard::missingIdKey();
        }

        if (!is_string($serialized['id'])) {
            throw InvalidSerializedCard::idNotString();
        }

        if (!array_key_exists('suite', $serialized)) {
            throw InvalidSerializedCard::missingSuite();
        }

        if (!in_array($serialized['suite'], Suite::all()) && $serialized['suite'] != Suite::JOKER()) {
            throw InvalidSerializedCard::invalidSuite($serialized['suite']);
        }

        if (!array_key_exists('value', $serialized)) {
            throw InvalidSerializedCard::missingValue();
        }

        $acceptedValues = array_merge(array_keys(CardContract::RANKS), [(new Joker())->value()]);
        if (!in_array($serialized['value'], $acceptedValues)) {
            throw InvalidSerializedCard::invalidValue($serialized['value']);
        }
    }

    private function isJoker(array $serialized): bool
    {
        return $serialized['suite'] == Suite::JOKER();
    }

    private function unserializeJoker(array $serialized): Joker
    {
        $joker = new Joker();
        $joker->setId($serialized['id']);

        return $joker;
    }

    private function unserializeCard(array $serialized): Card
    {
        $card = new Card(Suite::fromString($serialized['suite']), $serialized['value']);
        $card->setId($serialized['id']);

        return $card;
    }
}