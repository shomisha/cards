<?php

namespace Shomisha\Cards\Contracts;

interface Deck
{
    /**
     * Returns all the cards on the deck stack.
     * All of the cards are still available within the deck.
     *
     * @return array
     */
    public function cards(): array;

    /**
     * Draws the card from the top of the deck stack.
     * The drawn card is no longer available in the deck.
     *
     * @return \Shomisha\Cards\Contracts\Card
     */
    public function draw(): ?Card;

    /**
     * Puts a card on top of the deck stack.
     *
     * @param \Shomisha\Cards\Contracts\Card $card
     * @return $this
     */
    public function place(Card $card): self;

    /**
     * Puts a card to the specified position of the deck stack.
     *
     * @param \Shomisha\Cards\Contracts\Card $card
     * @param int $position
     * @return $this
     */
    public function put(Card $card, int $position): self;

    /**
     * Takes a card from the specified position of the deck stack.
     * The taken card is no longer available in the deck.
     *
     * @param int $position
     * @return \Shomisha\Cards\Contracts\Card
     */
    public function take(int $position): ?Card;
}