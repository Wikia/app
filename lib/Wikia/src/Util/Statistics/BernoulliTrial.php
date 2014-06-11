<?php
/**
 * Bernoulli Trial
 * Keywords: sample statistical probability
 *
 * A Bernoulli trial is a random experiment with two possible outcomes in
 * which the probability of success is the same for each trial. This class
 * provides a convenience method for creating a Bernoulli trial.
 *
 * You can use this to randomly sample high volume events where it may not be
 * feasible to include all of the events. Examples include high volume API
 * requests or or queries to a storage engine.
 *
 * Example:
 *	$sampler = new BernoulliTrial(0.1);
 *	if ($sampler->sample()) {
 *		// do something 10 % of the time
 *	}
 *
 */

namespace Wikia\Util\Statistics;

class BernoulliTrial {

	// Used to create a uniform distribution over 0-1. Don't change these.
	const MIN_MT_RAND_RANGE = 1.0;
	const MAX_MT_RAND_RANGE = 100.0;

	// The target range bounds
	const MIN_PROBABILITY = 0.0;
	const MAX_PROBABILITY = 1.0;

	/**
	 * @var float $probability
	 */
	private $probability = null;

	/**
	 * Create the trial with the given probability of success.
	 *
	 * @param float $probability the probability of success
	 */
	function __construct($probability) {
		$this->probability = $this->normalizeProbability($probability);
	}

	/**
	 * Get the probability of success.
	 *
	 * @return float
	 */
	public function getProbability() {
		return $this->probability;
	}

	/**
	 * Set the probability.
	 *
	 * @param float $probability the probability of success
	 */
	public function setProbability($probability) {
		$this->probability = $this->normalizeProbability($probability);
	}

	/**
	 * Sample an event from the trial. This will return true with the probability set
	 * in the trial and false otherwise.
	 *
	 * @return bool
	 */
	public function sample() {
		if ($this->getRandomFloat() <= $this->probability) {
			return true;
		}

		return false;
	}

	/**
	 * Get a random value from the distribution uniform distribution spanning 0.0 - 1.0
	 * inclusive.
	 *
	 * @return float
	 */
	public function getRandomFloat() {
		return mt_rand(self::MIN_MT_RAND_RANGE, self::MAX_MT_RAND_RANGE) / self::MAX_MT_RAND_RANGE;
	}

	/**
	 * Normalize the probability to the range [0-1].
	 *
	 * If the probability is > 1 then set it to 1. If the probability is < 0 then set it to 0.
	 *
	 * @param float $probability
	 * @return float
	 */
	public function normalizeProbability($probability) {
		return min(self::MAX_PROBABILITY, max($probability, self::MIN_PROBABILITY));
	}

}
