<?php

class Player {
	private $name;
	private $dice = [];
	private $temporaryDice = [];

	public function __construct($name){
		$this->name = $name;
	}

	public function getName(){
		return $this->name;
	}

	public function setDice($dice){
		$this->dice = $dice;
	}

	public function moveDice(Player $to_player){

		while(in_array(6, $this->dice)){
			$key = array_search(6, $this->dice);
			unset($this->dice[$key]);
		}
		
		while(in_array(1, $this->dice)){
			$key = array_search(1, $this->dice);
			if($to_player->getName() == "Player1"){
				$to_player->giveTemporaryDice();
			}else{
				$to_player->giveTemporaryDice($this->dice[$key]);
			}
			
			unset($this->dice[$key]);
		}

		if(count($this->temporaryDice) > 0){
			$this->dice = array_merge($this->dice,$this->temporaryDice);
			$this->temporaryDice = [];
		}

		if($this->totalDice() == 0){
			return false;
		}

		return true;
	}

	public function getTemporaryDice(){
		return $this->temporaryDice;
	}

	public function getDice(){
		return array_merge($this->dice,$this->temporaryDice);
	}

	public function giveTemporaryDice($vals=""){
		array_push($this->temporaryDice,1);
	}

	private function totalDice(){
		return count($this->dice);
	}
}

class Game {
	const total_player = 4;
	private $round;
	private $winner;
	private $player = [];

	public function __construct(){
		for ($i=1; $i <= self::total_player ; $i++) { 
			$this->player[$i] = new Player("Player".$i);
		}

		$this->winner = false;
	}

	public function startGame(){
		$this->round++;

		while($this->winner == false){
			echo "<b>Round $this->round <br></b>";

			$resultDicePlayer = [];
			echo "<p>After Dice Rolled</p>";

			//collect dice each player and then display it
			for ($i=1; $i <= self::total_player ; $i++) {
				
				$dice = [];

				if($this->round == 1){
					$count = 6;
				}else{
					$count = count($this->player[$i]->getDice());
				}

				for($j=0;$j<$count;$j++){
					$randomDice = rand(1,6);
					array_push($dice, $randomDice);
				}

				$this->player[$i]->setDice($dice);
				$resultDicePlayer[$i] = $dice;

				echo $this->player[$i]->getName().': ';
				foreach($resultDicePlayer[$i] as $val){
					echo $val.' ';
				}

				echo "<br>";
			}


			echo "<p>After moved/Removed</p>";

			//move process dice
			for($i=1;$i<=self::total_player; $i++){
				if($i == self::total_player){
					$move = $this->player[$i]->moveDice($this->player[$i-3]);
				}else{
					$move = $this->player[$i]->moveDice($this->player[$i+1]);
				}

				if($move == false){
					$this->winner= $this->player[$i]->getName();
				}
			}

			//display result dice after moved
			for ($i=1; $i <= self::total_player ; $i++) { 
				echo $this->player[$i]->getName().': ';
				foreach($this->player[$i]->getDice() as $val){
					echo $val.' ';
				}

				echo "<br>";
			}

			//check for winner
			if($this->winner !=false){
				echo "<h1><b>The winner is ".$this->winner."</b></h1>";
			}

			echo "<br>";
			$this->round++;
		}
	}
}

$game = new Game();
$game->startGame();