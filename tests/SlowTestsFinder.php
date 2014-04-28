<?php

class SlowTestsFinder extends PHPUnit_TextUI_Command {
	protected $slowTestsList = [];

	public function __construct() {
		$this->longOptions['slow-list'] = NULL;
	}

	public static function main($exit = TRUE) {
		$command = new static();
		return $command->run($_SERVER['argv'], $exit);
	}

	public function run( array $argv, $exit = TRUE ) {
		$this->handleArguments( $argv );

		print 'List of slow test cases:' . PHP_EOL;
		$this->walkThroughTests( $this->arguments['test'] );
		$this->displaySlowTestsList();
	}

	protected function walkThroughTests($test) {
		if ( $test instanceof PHPUnit_Framework_TestSuite ) {
			$tests = $test->tests();
			foreach ( $tests as $testCase ) {
				$this->walkThroughTests( $testCase );
			}
		} else {
			if ( WikiaTestSpeedAnnotator::isMarkedAsSlow( $test->getAnnotations() ) ) {
				$this->collectSlowTest($test);
				$this->displaySlowTest( $test );
			}
		}
	}

	protected function collectSlowTest( $test ) {
		if ( !isset( $this->slowTestsList[ get_class( $test ) ] )) {
			$this->slowTestsList[ get_class( $test ) ] = 1;
		} else {
			$this->slowTestsList[ get_class( $test ) ]++;
		}
	}

	protected function displaySlowTest( $test ) {
		print get_class( $test ) . '::' . $test->getName() . ' - '
			. WikiaTestSpeedAnnotator::getSlowExecutionTime( $test->getAnnotations() ) . 's' .PHP_EOL;
	}

	protected function displaySlowTestsList() {
		if ( !empty( $this->slowTestsList ) ) {
			print PHP_EOL . PHP_EOL . 'List of slow test classes:' . PHP_EOL;

			foreach ( $this->slowTestsList as $testName => $count) {
				print $testName . ' - ' . $count . ' slow tests' . PHP_EOL;
			}
		}
	}
}
