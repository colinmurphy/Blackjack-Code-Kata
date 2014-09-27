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
            $score += $card;
        }
        return $score;
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