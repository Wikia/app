<?php

namespace Wikia\AbPerfTesting\Criteria;

use Wikia\AbPerfTesting\Criterion;

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
	 * @param int $bucket wiki bucket ID to check
	 * @return boolean
	 */
	function applies($bucket) {
		return $this->mCityId % self::BUCKETS === $bucket;
	}
}
