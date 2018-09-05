<?php

/**
 * Script that removes wikicities.city_creation_log entries that are older than 30 days
 *
 * @see SUS-5782
 * @see SUS-4383
 * @author macbre
 * @file
 * @ingroup Maintenance
 */

require_once __DIR__ . '/../../../../maintenance/Maintenance.php';
require_once __DIR__ . '/../CreateNewWiki_setup.php';

class CleanupCityCreationLog extends Maintenance {

	public function execute() {
		global $wgExternalSharedDB;
		$db = wfGetDB( DB_MASTER, [], $wgExternalSharedDB );

		$db->delete(
			CreateWikiTask::CREATION_LOG_TABLE,
			[
				'creation_started < NOW() - INTERVAL 30 DAY'
			],
			__METHOD__
		);

		$this->output( sprintf(
			"Count of rows dropped from city_creation_log table: %d\n",
			$db->affectedRows()
		) );
	}
}

$maintClass = CleanupCityCreationLog::class;
require_once( RUN_MAINTENANCE_IF_MAIN );
