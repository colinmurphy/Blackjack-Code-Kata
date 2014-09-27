<?php

class Winner
{
    /**
     * Winners
     *
     * @var array
     */
    protected $_winners = [];

    /**
     * Players
     *
     * @var array
     */
    protected $_players = [];

    /**
     * Highest Score
     *
     * @var int
     */
    protected $_highestScore = 0;

    /**
     * Sets the players
     *
     * @param array $players
     */
    public function __construct(array $players)
    {
        $this->setPlayers($players);
        return $this;
    }

    /**
     * @param array $players
     *
     * @return $this
     */
    protected function setPlayers(array $players)
    {
        $this->_players = $players;
        return $this;
    }

    /**
     * Determines the winner or winners
     *
     * @return $this
     */
    public function determineWinner()
    {
        foreach ($this->getPlayers() as $player => $score) {

            if ($score === 0) {
                continue;
            }

            if ($score >= $this->getHighestScore()) {
                $this->setWinner($player, $score)
                    ->setHighestScore($score);
            }
        }
        return $this;
    }


    /**
     * Sets a winner
     *
     * @param string $player
     * @param int    $score
     *
     * @return $this
     */
    public function setWinner($player, $score)
    {
        $this->_winners[$score][] = $player;
        return $this;
    }

    /**
     * @param int $highestScore
     */
    protected function setHighestScore($highestScore)
    {
        $this->_highestScore = (int)$highestScore;
    }

    /**
     * Gets the winner
     *
     * @return string|array
     */
    public function getWinner()
    {
        // Zero
        if ($this->getHighestScore() === 0) {
            return false;
        }

        // No Winner
        $winners = $this->_winners;
        if (! array_key_exists($this->getHighestScore(), $winners)) {
            return false;
        }

        $winner = $winners[$this->getHighestScore()];

        return (count($winner) === 1)
            ? $winner[0]
            : $winner;
    }

    /**
     * Gets the players
     *
     * @return array
     */
    public function getPlayers()
    {
        return $this->_players;
    }

    /**
     * @return int
     */
    public function getHighestScore()
    {
        return $this->_highestScore;
    }

}