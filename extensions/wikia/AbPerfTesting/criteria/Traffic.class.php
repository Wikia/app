<?php

namespace Wikia\AbPerfTesting\Criteria;

use Wikia\AbPerfTesting\Criterion;

/**
 * Define a "traffic" criterion
 *
 * Take the beacon value and bucket all clients into 1000 groups
 *
 * beacon=3j-YqSr9BQ
 * beacon=8gQHS-Q4_c
 */
class Traffic extends Criterion {
	const BUCKETS = 1000;
	private $mBeaconId;

	function __construct() {
		$this->mBeaconId = wfGetBeaconId();
	}

	/**
	 * @param int $bucket traffic bucket ID to check
	 * @return boolean
	 */
	function applies($bucket) {
		return ($this->mBeaconId != '') && (crc32($this->mBeaconId) % self::BUCKETS === $bucket);
	}
}
