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

	const MAIN_QUEUE_NAME = 'mediawiki_main';
	const SMW_QUEUE_NAME = 'mediawiki_smw';
	const RTBF_QUEUE_NAME = 'mediawiki_rtbf';

	private $name;

	public function __construct( string $name = 'mediawiki_main' ) {
		$this->name = $name;
	}

	public function name() {
		return $this->name;
	}
}
