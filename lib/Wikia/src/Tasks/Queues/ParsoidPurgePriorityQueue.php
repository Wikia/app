<?php
/**
 * ParsoidPurgePriorityQueue
 *
 * <insert description here>
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace Wikia\Tasks\Queues;

class ParsoidPurgePriorityQueue extends Queue {
	const NAME = 'ParsoidPurgePriorityQueue';

	public function __construct() {
		parent::__construct('parsoid_purge_priority');
	}
} 