<?php

namespace Wikia\AbPerformanceTesting\Criteria;

use Wikia\AbPerformanceTesting\Criterion;

/**
 * Define a "wikis" criterion
 *
 * Uses 1000 buckets for city_id values
 */
class Wikis extends Criterion {
	const BUCKETS = 1000;
	private $mCityId;

	function __construct() {
		$this->mCityId = intval( \F::app()->wg->CityId );
	}

	/**
	 * @param int|array $bucket wiki bucket ID or range to check
	 * @return boolean
	 */
	function matches( $bucket ) {
		return $this->isInBucket( $this->mCityId % self::BUCKETS, $bucket );
	}
}
