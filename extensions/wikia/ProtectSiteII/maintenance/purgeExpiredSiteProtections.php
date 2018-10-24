<?php

require_once __DIR__ . '/../../../../maintenance/Maintenance.php';

class PurgeExpiredSiteProtections extends Maintenance {

	public function execute() {
		$model = new ProtectSiteModel();
		$model->deleteExpiredSettings();
	}
}

$maintClass = PurgeExpiredSiteProtections::class;
require_once RUN_MAINTENANCE_IF_MAIN;
