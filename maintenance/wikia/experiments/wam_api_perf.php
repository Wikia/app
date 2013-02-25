<?php

require_once( dirname(__FILE__) . '/../../commandLine.inc' );

class wamPerformanceTester {
	protected $app;
	protected $startTimes = array();
	protected $endTimes = array();

	public function resetTimes()  {
		$this->startTimes = array();
		$this->endTimes = array();
	}

	public function getAverageTime() {
		return (array_sum($this->endTimes) - array_sum($this->startTimes))/count($this->startTimes);
	}

	public function __construct() {
		$this->app = F::app();
	}

	public function runSingleTest() {
		echo "Running single...\n";
		$this->startTimes []= microtime(true);
		$wamIndex = $this->app->sendRequest('WAMApiController', 'getWAMIndex', array(
			'wam_day' => 1352505600,
			'wam_previous_day' => 1352505600,
			'fetch_admins' => true,
			'fetch_wiki_images' => true,
			'sort_direction' => 'DESC'
		))->getData();
		$this->endTimes []= microtime(true);
		return $wamIndex;
	}

	public function runMultipleTests($repetitions) {
		for ($i = 0; $i < $repetitions; $i++) {
			echo "Running multi $i...\n";
			$this->startTimes []= microtime(true);
			$this->runSingleTest();
			$this->endTimes []= microtime(true);
		}
	}
}

$testClass = new wamPerformanceTester();
$app = F::app();
$testClass->runSingleTest();
echo "\n\nElapsed time: " . $testClass->getAverageTime() . "\n";
$testClass->resetTimes();
$testClass->runMultipleTests(20);
echo "\n\nAverage time: " . $testClass->getAverageTime() . "\n";


/*
for ($i = 0; $i < 20; $i++) {
	$starttime = microtime(true);
	$wamIndex = $app->sendRequest('WAMApiController', 'getWAMIndex', array(
		'wam_day' => 1352505600,
		'wam_previous_day' => 1352505600,
		//'fetch_admins' => true,
		'fetch_wiki_images' => true,
		'sort_direction' => 'DESC'
	))->getData();

	$endtime = microtime(true);
	$averages [] = $endtime - $starttime;
}
echo "\n\nElapsed time: " . array_sum($averages) . ', average: ', array_sum($averages)/count($averages) . "\n";
var_dump(count($wamIndex['wam_index']));

*/