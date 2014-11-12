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
		$this->name = 'mediawiki_priority';
		$this->routingKey = 'mediawiki.priority';
	}
}