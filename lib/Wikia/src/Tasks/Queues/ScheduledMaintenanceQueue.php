<?php
namespace Wikia\Tasks\Queues;

class ScheduledMaintenanceQueue extends Queue {

	const NAME = 'ScheduledMaintenanceQueue';

	public function __construct() {
		$this->name = 'mediawiki_maintenance';
		$this->routingKey = 'mediawiki_maintenance';
	}
}
