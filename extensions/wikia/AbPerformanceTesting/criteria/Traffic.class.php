<?php

namespace Wikia\AbPerformanceTesting\Criteria;

use Wikia\AbPerformanceTesting\Criterion;

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
	 * @param int|array $bucket wiki bucket ID or range to check
	 * @return boolean
	 */
	function matches( $bucket ) {
		return ( $this->mBeaconId != '' ) && $this->isInBucket( crc32( $this->mBeaconId ) % self::BUCKETS, $bucket );
	}
}
