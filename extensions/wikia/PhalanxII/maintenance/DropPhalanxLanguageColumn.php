<?php
/**
 * Single-use maintenance script to remove language column from Phalanx DB
 * @package MediaWiki
 * @subpackage Maintenance
 */

require_once __DIR__ . '/../../../../maintenance/Maintenance.php';

class DropPhalanxLanguageColumn extends Maintenance {
	public function execute() {
		global $wgExternalSharedDB;

		$dbw = wfGetDB( DB_MASTER, [], $wgExternalSharedDB );
		wfWaitForSlaves( $wgExternalSharedDB );

		$query = 'ALTER TABLE phalanx DROP COLUMN p_lang;';

		$dbw->query( $query );
		$dbw->commit();
	}
}

$maintClass = DropPhalanxLanguageColumn::class;
require_once RUN_MAINTENANCE_IF_MAIN;
