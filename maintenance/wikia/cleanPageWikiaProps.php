<?php

require_once( __DIR__ . '/../Maintenance.php' );

define( "WPP_LVS_STATUS_INFO", 18 );
define( "WPP_LVS_SUGGEST", 19 );
define( "WPP_LVS_SUGGEST_DATE", 20 );
define( "WPP_LVS_EMPTY_SUGGEST", 21 );
define( "WPP_LVS_STATUS", 22 );

/**
 * Use this script together with "run_maintenance" to perform a cleanup of page_wikia_props table
 *
 * @see SYS-113
 */
class CleanPageWikiaPropsMaintenance extends Maintenance {

	const TABLE_NAME = 'page_wikia_props';

	public function execute() {
		global $wgDBname, $wgDBCluster;

		$this->output("Cleraning up page_wikia_props on {$wgDBname} ({$wgDBCluster})...");
		$dbw = $this->getDB( DB_MASTER );

		$then = microtime( true );
		$dbw->begin();
		$dbw->delete(
			self::TABLE_NAME,
			[
				'propname' => [
					WPP_LVS_STATUS_INFO,
					WPP_LVS_SUGGEST,
					WPP_LVS_SUGGEST_DATE,
					WPP_LVS_EMPTY_SUGGEST,
					WPP_LVS_STATUS,
				]
			],
			__METHOD__
		);
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

$maintClass = CleanPageWikiaPropsMaintenance::class;
require_once( RUN_MAINTENANCE_IF_MAIN );
