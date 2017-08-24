<?php

/*
e = empty space
w = wall
a = archer
*/

class ArcherGame {
	private $room;
	private $archers;
	private $wall;
	private $dimension = [];
	private $temp = [];


	public function __construct($dimension){
		$this->dimension = $dimension;
		
		//
		for($i=0;$i<$dimension;$i++){
			for($j=0;$j<$dimension;$j++){
				$this->room[$i][$j] = "e";
			}
		}
	}

	public function setWall($wall){
		$this->wall = $wall;

		foreach($wall as $values){
			$this->room[$values[0]][$values[1]] = "w";
		}
	}

	public function showRoom(){
		for($i=0;$i< $this->dimension;$i++){
			for($j=0;$j< $this->dimension;$j++){
				echo $this->room[$i][$j].' ';
			}

			echo "<br>";
		}
	}

	public function generateArcher(){
		for($i=0;$i< $this->dimension;$i++){
			for($j=0;$j< $this->dimension;$j++){
				$foundHorizontal = false;
				$foundVertical = false;

				//horizontal check
				for($x=0;$x < $this->dimension;$x++){
					if($this->room[$i][$x] == "e"){
						$foundHorizontal = false;
					}elseif($this->room[$i][$x] == "w"){
						$foundHorizontal = false;
					}elseif($this->room[$i][$x] == "a"){
						$foundHorizontal = true;
						break;
					}
				}

				//check vertical
				for($x=0;$x < $this->dimension; $x++){
					if($this->room[$x][$j] == "e"){
						$foundVertical = false;
					}elseif($this->room[$x][$j] == "w"){
						$foundVertical = false;;
					}elseif($this->room[$x][$j] == "a"){
						$foundVertical = true;
						break;
					}
				}
				
				//set archer
				if($foundVertical == false && $foundHorizontal == false){
					if($this->room[$i][$j] != "w"){
						$this->room[$i][$j] = "a";
						$this->archers++;
					}
				}
			}
		}

		array_push($this->temp,$this->room);
	}

	public function totalArcher(){
		return $this->archers;
	}

}

echo "e = empty room <br>";
echo "w = wall <br>";
echo "a = archer <br><br>";

$game = new ArcherGame(4,[]);
$game->setWall([[0,0],[0,1],[0,2],[2,1],[3,0],[3,1],[3,2]]);
echo "before add archers : <br>";
$game->showRoom();
echo "<br> after add archers : <br>";
$game->generateArcher();
$game->showRoom();
echo "<br> total archers : ".$game->totalArcher();