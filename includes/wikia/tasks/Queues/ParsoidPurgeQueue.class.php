<?php
/**
 * ParsoidPurgeQueue
 *
 * <insert description here>
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace Wikia\Tasks\Queues;

class ParsoidPurgeQueue extends Queue {
	const NAME = 'ParsoidPurgeQueue';

	public function __construct() {
		$this->name = 'parsoid_purge_tmp';
		$this->routingKey = 'mediawiki.parsoid_purge_tmp';
	}
} 