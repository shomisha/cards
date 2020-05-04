<?php

namespace Shomisha\Cards\Serializers\Player;

use Shomisha\Cards\Contracts\Game\Player;
use Shomisha\Cards\Contracts\Serializers\PlayerSerializer;
use Shomisha\Cards\Exceptions\Serialization\InvalidSerializedPlayer;
use Shomisha\Cards\Serializers\Hand\ArrayHandSerializer;

class ArrayPlayerSerializer implements PlayerSerializer
{
    /** @var \Shomisha\Cards\Serializers\Hand\ArrayHandSerializer  */
    private $handSerializer;

    public function __construct(ArrayHandSerializer $handSerializer)
    {
        $this->handSerializer = $handSerializer;
    }

    public function serialize(Player $player)
    {
        $id = $player->getId();
        $name = $player->name();
        $type = get_class($player);

        if ($hand = $player->getHand()) {
            $hand = $this->handSerializer->serialize($hand);
        }

        return [
            'id'   => $id,
            'type' => $type,
            'name' => $name,
            'hand' => $hand,
        ];
    }

    public function unserialize($serialized): Player
    {
        $this->validateSerialized($serialized);

        /** @var \Shomisha\Cards\Contracts\Game\Hand $hand */
        $hand = $this->handSerializer->unserialize($serialized['hand']);

        /** @var Player $player */
        $player = new $serialized['type'];

        $player->setId($serialized['id']);
        $player->setHand($hand);
        $player->setName($serialized['name']);

        return $player;
    }

    protected function validateSerialized(array $serialized)
    {
        if (!array_key_exists('id', $serialized)) {
            throw InvalidSerializedPlayer::missingIdKey();
        }

        if (!is_string($serialized['id'])) {
            throw InvalidSerializedPlayer::idNotString();
        }

        if (!array_key_exists('type', $serialized)) {
            throw InvalidSerializedPlayer::missingType();
        }

        if (!class_exists($serialized['type'])) {
            throw InvalidSerializedPlayer::typeDoesNotExist();
        }

        if (!in_array(Player::class, class_implements($serialized['type']))) {
            throw InvalidSerializedPlayer::typeNotPlayer();
        }

        if (!array_key_exists('name', $serialized)) {
            throw InvalidSerializedPlayer::missingName();
        }

        if (!is_string($serialized['name'])) {
            throw InvalidSerializedPlayer::nameNotString();
        }

        if (!array_key_exists('hand', $serialized)) {
            throw InvalidSerializedPlayer::missingHand();
        }

        if (!is_array($serialized['hand'])) {
            throw InvalidSerializedPlayer::handNotArray();
        }
    }
}