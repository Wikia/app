<?php
/**
 * Tests for Wikia\Util\Statistics\BernoulliTrial.
 */

use Wikia\Util\Statistics\BernoulliTrial;

class BernoulliTrialTest extends PHPUnit_Framework_TestCase {

	/**
	 * @param float $probability
	 * @param float $tolerance
	 * @param float $trials
	 * @dataProvider sampleProvider
	 */
	function testSample($probability, $tolerance, $trials) {
		$total     = 0;
		$trials    = (float)$trials;
		$tolerance = (float)$tolerance;

		$sampler = new BernoulliTrial($probability);
		for ($i=0; $i<$trials; $i++) {
			if ($sampler->sample()) {
				$total++;
			}
		}

		$actual = $total/$trials;
		$this->assertTrue(abs($actual - $probability) < $tolerance, sprintf("percent is %f %d %d", $actual, $total, $trials));
	}

	/**
	 * The data provider for testing sample. It's possible to determine the confidence interval for a sampling
	 * of Bernoulli trials. See http://stats.stackexchange.com/questions/4756/confidence-interval-for-bernoulli-sampling.
	 * For these tests, I approximated those values and added an order of magnitude.
	 *
	 */
	public function sampleProvider() {
		return array(
			# probability, tolerance from actual, sample size
			array(0.01, 0.005, 10000.0),
			array(1.0, 0.01, 10000.0),
			array(0.5, 0.08, 10000.0),
		);
	}

	/**
	 * @param float $provided
	 * @param float $expected
	 * @dataProvider normalizeProbabilityProvider
	 */
	public function testNormalizeProbability($provided, $expected) {
		$sampler = new BernoulliTrial($provided);
		$this->assertEquals($sampler->getProbability($provided), $expected);
		$this->assertEquals($sampler->normalizeProbability($provided), $expected);
	}

	/**
	 * Provide test cases for normalizing the probability provided.
	 */
	public function normalizeProbabilityProvider() {
		return array(
			array(0.0, 0.0),
			array(1.0, 1.0),
			array(-1.0, 0.0),
			array(1.1, 1.0),
		);
	}
}
