<?php

global 
	$beginTime;

function durationToString($seconds) {
	$hours = floor($seconds / 3600);
	$seconds -= $hours * 3600;
	$minutes = floor($seconds / 60);
	$seconds -= $minutes * 60;
	
	return str_pad($hours, 2, "0", STR_PAD_LEFT) .":". str_pad($minutes, 2, "0", STR_PAD_LEFT) .":". str_pad($seconds, 2, "0", STR_PAD_LEFT);
}

class ProgressBar {
	protected $maximum;
	protected $currentPosition;
	protected $lastProgressDisplayed;
	protected $refreshRate;
	protected $units;
	
	public function __construct($maximum = 0, $refreshRate = 0, $units = "") {
		$this->initialize($maximum, $refreshRate, $units);
	}
	
	public function initialize($maximum, $refreshRate, $units = "") {
		$this->maximum = $maximum;
		$this->currentPosition = 0;
		$this->lastProgressDisplayed = 0;
		$this->refreshRate = $refreshRate;
		$this->units = $units;
		
		$this->display();
	}
	
	protected function display() {
		global	
			$beginTime;
			
		if ($this->currentPosition == 0 || $this->currentPosition >= $this->lastProgressDisplayed + $this->refreshRate) {
			$this->lastProgressDisplayed = $this->currentPosition;
			$timeElapsed = time() - $beginTime;
			$barWidth = 45;
		
			if ($this->maximum > 0) {
				$percentage = floor(100 * $this->currentPosition / $this->maximum);
				$barFull = floor($barWidth * $this->currentPosition / $this->maximum);
			}
			else {
				$percentage = 100;
				$barFull = $barWidth;
			}	
			
			echo(
				"\r " . str_pad($percentage, 3, " ", STR_PAD_LEFT) . "% of " . $this->maximum . $this->units . " [". 
				str_repeat("=", $barFull) . str_repeat(" ", $barWidth - $barFull) .
				"] " . durationToString($timeElapsed)
			);
		}	
	}
	
	public function advance($amount) {
		$this->currentPosition += $amount;
		$this->display();		
	}
	
	public function setPosition($position) {
		$this->currentPosition = $position;
		$this->display();		
	}
	
	public function clear() {
		echo "\r" . str_repeat(" ", 79) . "\r";
	}
}
	

