<?php

use PHPUnit\Framework\BaseTestListener;
use PHPUnit\Framework\Test;
use PHPUnit\Framework\TestSuite;

class WikiaTestContextPrinter extends BaseTestListener {
	/** @var string $currentTestSuiteName */
	private $currentTestSuiteName;

	/** @var int $testCount */
	private $testCount = 0;

	/** @var int $skippedTestCount */
	private $skippedTestCount;

	/** @var int $incompleteTestCount */
	private $incompleteTestCount;

	/** @var int $executionTime */
	private $executionTime = 0;

	/**
	 * If the new test suite is a test class, reset statistics and output class name info.
	 *
	 * @param TestSuite $testSuite
	 */
	public function startTestSuite( TestSuite $testSuite ) {
		$testSuiteName = $testSuite->getName();
		$tryAutoloadClass = false;

		// Generic test suites cannot be mapped to classes
		if ( class_exists( $testSuiteName, $tryAutoloadClass ) ) {
			echo "\nRunning $testSuiteName ";

			$this->currentTestSuiteName = $testSuiteName;

			$this->testCount = 0;
			$this->skippedTestCount = 0;
			$this->incompleteTestCount = 0;
			$this->executionTime = 0;
		}
	}

	/**
	 * Increment the count of tests in the current test class.
	 *
	 * @param Test $test
	 */
	public function startTest( Test $test ) {
		$this->testCount++;
	}

	/**
	 * Increment the count of incomplete tests in the current test class.
	 *
	 * @param Test $test
	 * @param Exception $e
	 * @param float $time
	 */
	public function addIncompleteTest( Test $test, Exception $e, $time ) {
		$this->incompleteTestCount++;
	}

	/**
	 * Increment the count of skipped tests in the current test class.
	 *
	 * @param Test $test
	 * @param Exception $e
	 * @param float $time
	 */
	public function addSkippedTest( Test $test, Exception $e, $time ) {
		$this->skippedTestCount++;
	}

	public function endTest( Test $test, $time ) {
		$this->executionTime += $time;
	}

	/**
	 * Output execution time and test statistics for the test class that finished execution.
	 *
	 * @param TestSuite $testSuite
	 */
	public function endTestSuite( TestSuite $testSuite ) {
		if ( $testSuite->getName() === $this->currentTestSuiteName ) {
			// Convert execution time to milliseconds from seconds
			$this->executionTime *= 1000;

			echo
				sprintf(
				'done in %.2f ms [%d tests/%d skipped/%d incomplete]',
					$this->executionTime,
					$this->testCount,
					$this->skippedTestCount,
					$this->incompleteTestCount
				);
		}
	}
}
