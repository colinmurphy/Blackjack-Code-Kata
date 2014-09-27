<?php

/**
 * Calculates the card score
 *
 *
 * @author    Colin Murphy <colin@colinfmurphy.com>
 * @copyright 2014 Colin Murphy
 */
class CardScore
{
    /**
     * Cards
     *
     * @var array
     */
    protected $_cards = [];

    /**
     * Score
     *
     * @var int
     */
    protected $_score = 0;

    /**
     * Sets the cards
     *
     * @param array $cards
     */
    public function __construct(array $cards)
    {
        $this->setCards($cards);
        return $this;
    }

    /**
     * Calculates the card score
     *
     * @return $this
     */
    public function calculateCardScore()
    {
        $score = 0;
        foreach ($this->getCards() as $card) {
            $score += $this->getCardScore($card);
        }

        if ($score > $this->getScoreLimit()) {
            if ($this->hasAces()) {
                $score = $this->setAceScoresToOne($score);
            }
            if ($score > $this->getScoreLimit()) {
                $score = 0;
            }
        }

        $this->setScore($score);
        return $this;
    }

    /**
     * Check For Aces
     *
     *
     * @return bool
     */
    protected function hasAces()
    {
        foreach ($this->getCards() as $card) {
            if (strtolower($card) === 'ace') {
                return true;
            }
        }
        return false;
    }

    protected function setAceScoresToOne($score)
    {
        $cards = $this->getCards();
        foreach ($cards as $card) {
            if ($card == 'ace') {
                $score += 1;
                $score -= $this->getCardScore($card);
            }
        }
        return $score;
    }


    /**
     * Score Limit
     *
     * @return int
     */
    protected function getScoreLimit()
    {
        return 21;
    }

    /**
     * Gets the card score
     *
     * @param $card
     *
     * @return int
     */
    protected function getCardScore($card)
    {
        return (array_key_exists($card, $this->getCardValues()))
            ? $this->getCardValues()[$card]
            : 0;
    }

    /**
     * Card Values
     *
     * @return array
     */
    protected function getCardValues()
    {
        return [
            '2'     => 2,
            '3'     => 3,
            '4'     => 4,
            '5'     => 5,
            '6'     => 6,
            '7'     => 7,
            '8'     => 8,
            '9'     => 9,
            '10'    => 10,
            'jack'  => 10,
            'queen' => 10,
            'king'  => 10,
            'ace'   => 11,
        ];
    }

    /**
     * @param array $cards
     */
    protected function setCards($cards)
    {
        $this->_cards = $cards;
    }

    /**
     * @param int $score
     */
    protected function setScore($score)
    {
        $this->_score = $score;
    }

    /**
     * @return array
     */
    public function getCards()
    {
        return $this->_cards;
    }

    /**
     * @return int
     */
    public function getScore()
    {
        return $this->_score;
    }

}