<?php

namespace Wikia\Measurements;

class TimePerformance extends \WikiaBaseTest {

	public function testMeasuredPerformance() {
		$start = \microtime(true);
		for( $i = 0; $i < 1000; $i++ ) {
			$this->measured();
		}
		echo "\nmeasured:   " . (\microtime(true) - $start) . "\n";
	}
	public function testNotMeasuredPerformance() {
		$start = \microtime(true);
		for( $i = 0; $i < 1000; $i++ ) {
			$this->notMeasured();
		}
		echo "\nnot measured:" . (\microtime(true) - $start) . "\n";
	}

	private function notMeasured() {
		return 1;
	}

	private function measured() {
		$measure = Time::start("dummy");
		return 1;
	}
}
