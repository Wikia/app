<?php
/**
 * BaseQueue
 *
 * <insert description here>
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace Wikia\Tasks\Queues;


class Queue {
	const NAME = 'Queue';

	const RTBF_QUEUE_NAME = 'mediawiki_rtbf';

	protected $name;
	protected $routingKey;

	public function __construct( string $name = 'mediawiki_main' ) {
		$this->name = $name;
		$this->routingKey = 'mediawiki.main';
	}

	public function name() {
		return $this->name;
	}

	/**
	 * @deprecated
	 * @return string
	 */
	public function routingKey() {
		return $this->routingKey;
	}
}
