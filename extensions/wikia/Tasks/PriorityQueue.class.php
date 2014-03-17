<?php
/**
 * HighPriorityQueue
 *
 * <insert description here>
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace Wikia\Tasks;


class PriorityQueue extends Queue {
	public function __construct() {
		$this->name = 'mediawiki_priority';
		$this->routingKey = 'mediawiki.priority';
	}
}