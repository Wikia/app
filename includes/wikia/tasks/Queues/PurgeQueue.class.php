<?php
/**
 * PurgeQueue
 *
 * For purging varnish (Fastly or internal)
 *
 */

namespace Wikia\Tasks\Queues;


class PurgeQueue extends Queue {
	const NAME = 'PurgeQueue';

	public function __construct() {
		$this->name = 'purger';
		$this->routingKey = 'purger';
	}
}
