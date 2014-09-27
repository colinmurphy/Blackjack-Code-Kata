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
     * Array of players with perfect scores
     *
     * @var array
     */
    protected $_perfectScorePlayers = [];

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

            if ($this->hasJointHighestScore($score)) {

                if ($this->hasLowestCardScore($cards)
                    || $this->isDealer($player)
                ) {
                    $this->removeWinner();
                }

                $perfectScorePlayers = $this->getPerfectScorePlayers();
                if ($this->isDealer($player) && ! empty($perfectScorePlayers)) {

                    if (! $this->hasPerfectScore($cards, $score)) {
                        foreach ($perfectScorePlayers as $perfectPlayer) {
                            $this->setWinner($perfectPlayer);
                        }
                        continue;
                    }

                }


            }


            if ($this->hasLowestCardScore($cards)) {
                $this->setLowestCardScore(count($cards));
            }

            $this->setWinner($player)
                ->setHighestScore($score);

            if ($this->hasPerfectScore($cards, $score)) {
                $this->setPerfectScorePlayers($player);
            }

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
     * Checks to see if we have a new high score
     *
     * @param int $score
     *
     * @return bool
     */
    protected function hasJointHighestScore($score)
    {
        return (int)$score === $this->getHighestScore();
    }

    /**
     * Checks to see if we have a new high score
     *
     * @param array $cards
     *
     * @return bool
     */
    protected function hasLowestCardScore(array $cards)
    {
        return count($cards) < $this->getLowestCardScore();
    }

    /**
     * Checks if the player is the dealer
     *
     * @param string $player
     *
     * @return bool
     */
    protected function isDealer($player)
    {
        return strtolower($player) === 'dealer';
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
     *
     * @return $this
     */
    public function setWinner($player)
    {
        $this->_winners[] = $player;
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
            return $winners[0];
        }

        return $winners;
    }

    /**
     * Checks to see if the player has the perfect score
     *
     * @param array $cards
     * @param int $score
     *
     * @return bool
     */
    public function hasPerfectScore(array $cards, $score)
    {
        return count($cards) === 2 && (int)$score === 21;
    }

    /**
     * @param string $player
     */
    protected function setPerfectScorePlayers($player)
    {
        $this->_perfectScorePlayers[] = $player;
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

    /**
     * @return array
     */
    public function getPerfectScorePlayers()
    {
        return $this->_perfectScorePlayers;
    }

}