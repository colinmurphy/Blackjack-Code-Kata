<?php

/**
 * Blackjack
 *
 * This determines who wins a game of BlackJack
 *
 *
 * @author    Colin Murphy <colin@colinfmurphy.com>
 * @copyright 2014 Colin Murphy
 *
 */
class BlackJackGame
{

    protected $_players = [];

    /**
     * Sets a player
     *
     * @param       $player
     * @param array $cards
     */
    public function setPlayer($player, array $cards)
    {
        $this->_players[$player] = $this->calculateScore($cards);
    }

    /**
     * Calculates the scores
     *
     * @param array $cards
     *
     * @return int
     */
    protected function calculateScore(array $cards)
    {
        $score = 0;
        foreach ($cards as $card) {
            $score += $this->getCardScore($card);
        }
        return $score;
    }

    /**
     * @param $card
     *
     * @return int
     */
    protected function getCardScore($card)
    {
        return ( array_key_exists($card, $this->getCardValues()) )
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
     * @return array
     */
    public function getPlayers()
    {
        return $this->_players;
    }

    /**
     * Gets the winner
     *
     * @return string
     */
    public function getWinner()
    {
        $winner = '';
        $highestScore = 0;
        foreach ($this->getPlayers() as $player => $score) {

            if ($score > $highestScore) {
                $winner = $player;
                $highestScore = $score;
            }

        }
        return $winner;
    }

}