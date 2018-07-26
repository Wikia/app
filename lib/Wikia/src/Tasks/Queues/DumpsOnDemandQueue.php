<?php

namespace Wikia\Tasks\Queues;

class DumpsOnDemandQueue extends Queue {
	const NAME = 'DumpsOnDemandQueue';

	public function __construct() {
		parent::__construct('mediawiki_dumps_on_demand');
	}
}
