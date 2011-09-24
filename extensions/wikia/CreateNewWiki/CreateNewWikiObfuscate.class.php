<?php
class CreateNewWikiObfuscate {

	public static function generateValidSeeds() {
		$absmax = pow(2, 31);
		$invalid = true;
		$counter = 0;
		while($invalid) {
			$seeds = self::generateSeeds();
			$answer = self::generateAnswer($seeds);
			$absanswer = abs($answer);
			$invalid = ($absanswer < 10000 || $absanswer >= $absmax) && $counter < 100;
			$counter++;
		}
		return $seeds;
	}
	
	public static function generateSeeds() {
		$seeds = array();
		$numOfSeeds = rand(20, 30);
		for($i = 0; $i < $numOfSeeds; $i++) {
			$seeds[] = rand(1, 9);
		}
		return $seeds;
	}

	public static function generateAnswer($keys) {
		$value = 0;
		for($i = 0; $i < count($keys); $i++) {
			$value *= ($i % 5) + 1;
			$value += $keys[$i];
		}
		return $value;
	}

}