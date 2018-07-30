<?php
/**
 * HighPriorityQueue
 *
 * <insert description here>
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace Wikia\Tasks\Queues;


class PriorityQueue extends Queue {
	const NAME = 'PriorityQueue';

	public function __construct() {
		parent::__construct('mediawiki_priority');
	}
}