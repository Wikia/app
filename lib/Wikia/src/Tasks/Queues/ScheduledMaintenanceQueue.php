<?php
namespace Wikia\Tasks\Queues;

class ScheduledMaintenanceQueue extends Queue {

	const NAME = 'ScheduledMaintenanceQueue';

	public function __construct() {
		parent::__construct('mediawiki_maintenance');
	}
}
