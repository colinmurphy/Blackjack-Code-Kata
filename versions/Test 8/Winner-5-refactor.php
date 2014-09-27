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
     * Lowest Card Score
     *
     * @var int
     */
    protected $_lowestCardScore = 5;

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
        foreach ($this->getPlayers() as $player => $attributes) {

            $score = $attributes['score'];
            $cards = $attributes['cards'];

            if ($score === 0 || $score < $this->getHighestScore()) {
                continue;
            }

            if ($this->hasNewHighestScore($score)) {
                $this->removeWinner();
            }

            $this->setWinner($player, count($cards))
                ->setHighestScore($score);
        }
        return $this;
    }

    /**
     * Checks to see if we have a new high score
     *
     * @param int $score
     *
     * @return bool
     */
    protected function hasNewHighestScore($score)
    {
        return (int)$score > $this->getHighestScore();
    }


    /**
     * Removes the winner
     */
    protected function removeWinner()
    {
        $this->_winners = [];
    }


    /**
     * Sets a winner
     *
     * @param string $player
     * @param int    $cardCount
     *
     * @return $this
     */
    public function setWinner($player, $cardCount)
    {
        $this->_winners[] = [
            'player'    => $player,
            'cardCount' => $cardCount
        ];
        return $this;
    }

    /**
     * @param int $highestScore
     *
     * @return $this
     */
    protected function setHighestScore($highestScore)
    {
        $this->_highestScore = (int)$highestScore;
        return $this;
    }

    /**
     * @param int $lowestCardScore
     *
     * @return $this
     */
    public function setLowestCardScore($lowestCardScore)
    {
        $this->_lowestCardScore = (int)$lowestCardScore;
        return $this;
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
        if (count($winners) === 1) {
            return $winners[0]['player'];
        }

        $winners = [];
        foreach ($this->_winners as $winner) {

            if ($winner['cardCount'] > $this->getLowestCardScore()) {
                continue;
            }
            $this->setLowestCardScore($winner['cardCount']);
            $winners[$winner['cardCount']][] = $winner['player'];
        }

        $winner = $winners[$this->getLowestCardScore()];

        if (count($winner) === 1) {
            return $winner[0];
        }
        return $winner;

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

    /**
     * @return int
     */
    public function getLowestCardScore()
    {
        return $this->_lowestCardScore;
    }

}