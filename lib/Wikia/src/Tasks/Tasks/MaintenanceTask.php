<?php

namespace Wikia\Tasks\Tasks;

use Maintenance;

class MaintenanceTask extends BaseTask {

	public function run( $className, $opts, $args ) {
		/* @var Maintenance $maintenanceScript */
		$maintenanceScript = new $className;
		$maintenanceScript->loadParamsAndArgs( $className, $opts, $args );
		$maintenanceScript->execute();
	}
}
