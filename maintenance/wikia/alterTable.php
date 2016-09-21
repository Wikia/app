<?php

require_once( __DIR__ . '/../Maintenance.php' );

/**
 * Use this script together with "run_,maintenance" to perform a batch table alter
 *
 * @see PLATFORM-1581
 */
class AlterTableMaintenance extends Maintenance {

	const ALTER_QUERY = 'ALTER TABLE page_wikia_props DROP PRIMARY KEY, ADD INDEX page_id (`page_id`), ADD INDEX propname (`propname`)';

	public function execute() {
		global $wgDBname, $wgDBCluster;

		$this->output("Altering indices on {$wgDBname} ({$wgDBCluster})...");
		$dbw = $this->getDB( DB_MASTER );

		$then = microtime( true );
		$dbw->query( self::ALTER_QUERY, __METHOD__);
		$dbw->commit();
		$took = microtime( true ) - $then;

		wfWaitForSlaves();

		Wikia\Logger\WikiaLogger::instance()->info( __METHOD__, [
			'cluster' => $wgDBCluster,
			'took' => round($took, 6),
		] );

		$this->output(" done\n");
	}
}

$maintClass = AlterTableMaintenance::class;
require_once( RUN_MAINTENANCE_IF_MAIN );

