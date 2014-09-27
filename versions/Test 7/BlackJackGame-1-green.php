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
        $score = new CardScore($cards);
        $score->calculateCardScore();
        return $score->getScore();
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
        $winners = [];
        $highestScore = 0;
        foreach ($this->getPlayers() as $player => $score) {

            if ($score === 0) {
                continue;
            }

            if ($score >= $highestScore) {
                $winners[$score][] = $player;
                $highestScore = $score;
            }
        }

        if ($highestScore === 0
            || !array_key_exists($highestScore, $winners)
        ) {
            return false;
        }

        $winner = $winners[$highestScore];

        return (count($winner) === 1)
            ? $winner[0]
            : $winner;
    }

}