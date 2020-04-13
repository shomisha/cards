# Card deck

[![Latest Stable Version](https://img.shields.io/packagist/v/shomisha/cards)](https://packagist.org/packages/shomisha/cards)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat)](LICENSE.md)

This package provides a simple implementation of a card deck using object-oriented PHP. 
In addition to `Deck` and `Card` classes it contains a `Shuffler` class for shuffling decks and a `DeckBuilder` class for creating decks.


## Installation

You can install this package via Composer. To do so, simply run the following command from the root of your project:

```bash
composer require shomisha/cards
```


## Usage

As mentioned earlier, there are four main classes:

1. `Shomisha\Cards\DeckBuilders\DeckBuilder`
2. `Shomisha\Cards\Decks\Deck`
3. `Shomisha\Cards\Cards\Card`
4. `Shomisha\Cards\Shufflers\Shuffler`

In addition to these classes, there is a `Shomisha\Cards\Suites\Suite` class which is used as an enum for card suites
and a `Shomisha\Cards\Cards\Joker` class used for representing jokers in decks.

### `DeckBuilder`

The `Shomisha\Cards\DeckBuilders\DeckBuilder` class is basically a factory for decks. It exposes two methods for creating instances of the `Deck` class:

- `build()`
- `buildMultiple(int $count)`

The `build()` method returns an instance of the `Deck` class that has 54 cards, the standard 52 ones and two jokers. 
It is possible to create a deck without jokers, you can read about that later in this chapter.

The `buildMultiple(int $count)` still creates a single instance of a `Deck`, but it fills it with `$count * 54` cards, 
i.e. the `$count` argument specifies the number of decks that would be fitted into this one deck. 
Again, it is possible to use this method to build decks without jokers, in which case the created deck would contain `$count * 52` cards.


#### `withJokers(bool $withJokers = true)`

In order to create decks with or without jokers you can use the `withJokers(bool $withJokers = true)` method which takes a single argument, 
`true` or `false`. Naturally, `true` will create a deck with jokers, whereas `false` will omit jokers from the created decks.

It is important to note that this command is immutable, meaning that it will not alter the instance it is called upon
but create a new instance and set the desired value on it. Here is an example:

```php
$builder = new \Shomisha\Cards\DeckBuilders\DeckBuilder();

$deck = $builder->build(); // Returns a deck with jokers
count($deck->cards()); // 54

$deck = $builder->withJokers(false)->build(); // Returns a deck without jokers
count($deck->cards()); // 52

$deck = $builder->buildMultiple(2);
count($deck->cards()); // 108

$deck = $builder->withJokers(false)->buildMultiple(2);
count($deck->cards()); // 104
```   

What happened is that the call to `withJokers()` created a new instance of the builder which wasn't saved to any variable.
Calling the `build()` method on the original builder still created a deck with jokers because that instance wasn't modified by the `withJokers()` call.
The same applies to the `buildMultiple()` calls.


### `Deck`

The `Shomisha\Cards\Decks\Deck` is the main object in this package. It is a class that is designed to act as a real deck of cards
and provide its users with the abilities they would have with an actual deck.

It contains the following methods:

- `cards(): array`
- `draw(): ?Shomisha\Cards\Cards\Card`
- `take(int $position): ?Shomisha\Cards\Cards\Card`
- `place(Card $card): Shomisha\Cards\Decks\Deck`
- `put(Card $card, int $position): Shomisha\Cards\Decks\Deck`


#### The `cards()` method

This method returns an array of all of the cards on the deck at the moment of invoking it. 
The elements of this array are all instances of the card classes (regular card or joker).

Keep in mind that this method returns the array of cards by value, which means any changes you 
make to this array will not reflect on the state of the deck.

This method is primarily implemented for testing, it is recommended you do not use it and rely on other methods instead.


#### The `draw()` method

The name of the `draw()` method is rather self-explanatory, it draws a card from the top of the deck.

It returns an instance of card classes. It is important to keep in mind that drawing a card actually removes the returned card from the deck.
If the deck is empty, this method will return null.

Consider the following example:

```php
use Shomisha\Cards\DeckBuilders\DeckBuilder;

$deck = (new DeckBuilder())->withJokers(false)->build();

count($deck->cards()); // Returns 52

$drawnCard = $deck->draw(); // Returns a Card instance

count($deck->cards()); // Returns 51

$deck->draw(); // Returns a Card instance
$deck->draw(); // Returns a Card instance

count($deck->cards()); // Returns 49
```

The newly instantiated deck has 52 cards because we created it without jokers.
After the first draw, it has 51 remaining cards, in turn after the following two draws it stays with 49 cards.

#### The `take(int $position)` method

This method is similair to the `take()` one except for one important difference: it does not return the top card from the deck
but the one from the position specified using the `$position` argument. 
If there is no card at the requested position the method will return null.

As its `draw()` counterpart, the card that is taken from the deck is no longer available in the deck.

Here is an example:

```php
use Shomisha\Cards\DeckBuilders\DeckBuilder;

$deck = (new DeckBuilder())->withJokers(false)->build();

count($deck->cards()); // Returns 52

$drawnCard = $deck->take(12); // Returns a Card instance

count($deck->cards()); // Returns 51

$deck->take(33); // Returns a Card instance
$deck->take(29); // Returns a Card instance

count($deck->cards()); // Returns 49
```

The example closely resembles the previous one except the instances of the taken cards were not sequential and of the top of the deck
but rather ones from the targeted positions.

After taking a card from the deck, all of the remaining cards will be rekeyed to preserve a sequential array with keys ranging from `0` to `n - 1` where `n` is the number of cards in the deck.


#### The `place(Card $card)` method

The `place(Card $card)` method is, in a way, the opposite of the `draw()` method because it places a card on top of the deck. 
This method modifies the deck it is called upon.

Take a look at this example:

```php
use Shomisha\Cards\Cards\Joker;
use Shomisha\Cards\DeckBuilders\DeckBuilder;

$deck = (new DeckBuilder())->withJokers(false)->build();
count($deck->cards()); // Returns 52

$deck->place(new Joker());
count($deck->cards()); // Returns 53

$deck->draw(); // Returns the previously created instance of Joker
count($deck->cards()); // Returns 52
```


#### The `put(Card $card, int $position)` method

This method provides similair behaviour as the `place()` method, 
with the difference of putting the card at the specified position, instead of the top of the deck. 
Same as its sibling method, it modifies the deck called upon.

```php
use Shomisha\Cards\Cards\Joker;
use Shomisha\Cards\DeckBuilders\DeckBuilder;

$deck = (new DeckBuilder())->withJokers(false)->build();

$deck->put(new Joker(), 42);
$deck->take(42); // Returns the previously created Joker.
``` 

If a card already exists at the provided position, the new card will not override the existing one but rather increment the positions of all latter cards in order to make room for itself.


### `Card`

The `Shomisha\Cards\Cards\Card` class is essentially a data object used for representing cards.

This class exposes four methods:

- `identifier(): string`
- `rank(): string`
- `value(): int`
- `suite(): Shomisha\Cards\Suites\Suite`

#### The `identifier()` method

This method is used to uniquely define a cards value and suite. 
It returns a combination of the cards suite and its numeric value encoded in a single string.

Here is an example:

```php
use Shomisha\Cards\Cards\Card;
use Shomisha\Cards\Suites\Suite;

$card = new Card(Suite::SPADES(), 10);

$card->identifier(); // Returns "spades-10"
```

It is recommended that you resort to the `value()` and `suite()` methods for establishing 
a cards identity, however the `identifier()` method can be used for this purpose too.


#### The `rank()` method

The `rank()` method is used for obtaining the 'name' of the card. 
For cards with no special meaning it simply returns the English word for the value of that card.
For face cards it returns the name of the card in English.

These are the values each cards' `rank()` method would return:

```text
 1 => "Ace"
 2 => "Two"
 3 => "Three"
 4 => "Four"
 5 => "Five"
 6 => "Six"
 7 => "Seven"
 8 => "Eight"
 9 => "Nine"
10 => "Ten"
12 => "Jack"
13 => "Queen"
14 => "King"
```

Here is an example:

```php
use Shomisha\Cards\Cards\Card;
use Shomisha\Cards\Suites\Suite;

$cards = [
    new Card(Suite::SPADES(), 1),
    new Card(Suite::SPADES(), 2),
    new Card(Suite::SPADES(), 12),
    new Card(Suite::SPADES(), 14),
];

$cards[0]->rank(); // returns "Ace"
$cards[1]->rank(); // returns "Two"
$cards[2]->rank(); // returns "Jack"
$cards[3]->rank(); // returns "King"
```


#### The `value()` method

The `value()` method is rather simple, it returns the numeric value of the card called upon.

Here is an example:

```php
use Shomisha\Cards\Cards\Card;
use Shomisha\Cards\Suites\Suite;

$cards = [
    new Card(Suite::SPADES(), 1),
    new Card(Suite::SPADES(), 2),
    new Card(Suite::SPADES(), 12),
    new Card(Suite::SPADES(), 14),
];

$cards[0]->value(); // returns 1
$cards[1]->value(); // returns 2
$cards[2]->value(); // returns 12
$cards[3]->value(); // returns 14
```

#### The `suite()` method

The `suite()` method can be used to access the suite of the card.
This method returns an instance of the `Shomisha\Cards\Suites\Suite` which is an enum class.

Instances of the `Suite` class have a single method: `name()`. It returns a string, the English word for the suite in question.

In addition to this method, the `Suite` class also has a `__toString()` method which is used to automatically cast the object to a string.
In other words, you may freely use the return value of the `$card->suite()` method as a string.

Here is an example:

```php
use Shomisha\Cards\Cards\Card;
use Shomisha\Cards\Suites\Suite;


$card = new Card(Suite::HEARTS(), 10);

$suite = $card->suite(); // Returns an instance of Shomisha\Cards\Suites\Suite;

$suite->name() == 'hearts';  // true
$suite->name() === 'hearts'; // true

$suite == 'hearts';  // true
$suite === 'hearts'; // false

$suite->name() == Suite::HEARTS();  // true
$suite->name() === Suite::HEARTS(); // false

$suite == Suite::HEARTS();  // true
$suite === Suite::HEARTS(); // false
```

#### The `Shomisha\Cards\Cards\Joker` class

The `Shomisha\Cards\Cards\Joker` class is used for representing jokers in decks.
It does not extend the `Shomisha\Cards\Cards\Card` class but it does implement the `Shomisha\Cards\Contracts\Card` interface and is thus part of the same tree.

The only difference it has from the base card class is that its methods always return the same values:

```php
use Shomisha\Cards\Cards\Joker;

$joker = new Joker();

$joker->rank(); // Returns "joker"
$joker->value(); // Returns 15
$joker->identifier(); // Returns "joker"

(string) $joker->suite(); // Returns "joker"
``` 

### `Shuffler`

The `Shomisha\Cards\Shufflers\Shuffler` is used, as its name suggests, for shuffling decks of cards.

It exposes a single method called `shuffle(Deck $deck, int $rounds = 1)`.
The first argument to this method is the deck to be shuffled. It is important to keep in mind that this method will modify the deck passed in, it will not create a new deck.

The second argument is the number of times the deck should be shuffled. The higher the number passed in, the higher the randomization of the card sequence in the deck.

```php
use Shomisha\Cards\DeckBuilders\DeckBuilder;
use Shomisha\Cards\Shufflers\Shuffler;

$deck = (new DeckBuilder())->build();
$deck->cards()[0]->identifier(); // Returns "clubs-1"

(new Shuffler())->shuffle($deck, 3);

$deck->cards()[0]->identifier(); // Returns "spades-7"
```

Please note that the example above is random, the `spades-7` will not always be the first card in the deck after shuffling.

The shuffler can work with decks of any size, it is irrelevant if cards have previously been taken out of the deck or if the deck consists of multiple decks.