<?php

class BlackJackGameTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var BlackJackGame
     */
    protected $game;

    public function setup()
    {
        $this->game = new BlackJackGame();
    }

    /**
     * @return BlackJackGame
     */
    public function getGame()
    {
        return $this->game;
    }

    public function test_two_players_no_picture_cards()
    {
        $this->getGame()->setPlayer('Player 1', array(2, 3));
        $this->getGame()->setPlayer('Player 2', array(9, 9));
        $this->assertEquals('Player 2', $this->getGame()->getWinner());
    }

    public function test_two_players_with_picture_cards()
    {
        $this->getGame()->setPlayer('Player 1', array(4, 2));
        $this->getGame()->setPlayer('Player 2', array('jack', 'queen'));
        $this->assertEquals('Player 2', $this->getGame()->getWinner());
    }

    public function test_two_players_one_over_21()
    {
        $this->getGame()->setPlayer('Player 1', array(6, 9));
        $this->getGame()->setPlayer('Player 2', array('jack', 'queen', 'king'));
        $this->assertEquals('Player 1', $this->getGame()->getWinner());
    }

    public function test_two_players_one_with_two_aces()
    {
        $this->getGame()->setPlayer('Player 1', array(2, 3));
        $this->getGame()->setPlayer('Player 2', array('ace', 'jack', 'queen'));
        $this->assertEquals('Player 2', $this->getGame()->getWinner());
    }

    public function test_two_players_one_with_two_over_five_cards()
    {
        $this->getGame()->setPlayer('Player 1', array(2, 3));
        $this->getGame()->setPlayer('Player 2', array('ace', 2, 2, 2, 2, 2));
        $this->assertEquals('Player 1', $this->getGame()->getWinner());
    }

    public function test_two_players_with_both_over_21()
    {
        $this->getGame()->setPlayer('Player 1', array('jack', 'queen', 9));
        $this->getGame()->setPlayer('Player 2', array('jack', 'queen', 2));
        $this->assertEquals(false, $this->getGame()->getWinner());
    }

    public function test_two_players_with_same_score_same_amount_of_cards()
    {
        $this->getGame()->setPlayer('Player 1', array('jack', 'queen', 'ace'));
        $this->getGame()->setPlayer('Player 2', array('jack', 'queen', 'ace'));
        $this->assertEquals(array('Player 1', 'Player 2'), $this->getGame()->getWinner());
    }

    public function test_two_players_with_same_score_one_with_less_cards()
    {
        $this->getGame()->setPlayer('Player 1', array('jack', 'queen', 'ace'));
        $this->getGame()->setPlayer('Player 2', array('jack', 'ace'));
        $this->assertEquals('Player 2', $this->getGame()->getWinner());
    }

    public function test_player_dealer_same_score_wins()
    {
        $this->getGame()->setPlayer('Player 1', array('jack', 'queen'));
        $this->getGame()->setPlayer('Dealer', array('jack', 5, 5));
        $this->assertEquals('Dealer', $this->getGame()->getWinner());
    }

    public function test_player_with_perfect_score_dealer_same_score_player_wins()
    {
        $this->getGame()->setPlayer('Player 1', array('jack', 'ace'));
        $this->getGame()->setPlayer('Player 2', array('jack', 9, 2));
        $this->getGame()->setPlayer('Dealer', array('jack', 5, 6));
        $this->assertEquals('Player 1', $this->getGame()->getWinner());
    }

    public function test_player_and_dealer_with_perfect_score_dealer_wins()
    {
        $this->getGame()->setPlayer('Player 1', array('jack', 'ace'));
        $this->getGame()->setPlayer('Player 2', array('jack', 9, 2));
        $this->getGame()->setPlayer('Dealer', array('jack', 'ace'));
        $this->assertEquals('Dealer', $this->getGame()->getWinner());
    }

}