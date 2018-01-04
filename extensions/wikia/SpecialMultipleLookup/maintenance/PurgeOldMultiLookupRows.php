<?php

require_once __DIR__ . '/../../../../maintenance/Maintenance.php';

class PurgeOldMultiLookupRows extends Maintenance {

	public function __construct() {
		parent::__construct();
		$this->mDescription = 'Delete old rows from specials.multilookup table. Honors $wgRCMaxAge setting.';
	}

	public function execute() {
		global $wgRCMaxAge, $wgSpecialsDB;

		$dbw = wfGetDB( DB_MASTER, [], $wgSpecialsDB );
		$maxDays = $dbw->addQuotes( $wgRCMaxAge / 86400 );
		$rows = 0;

		do {
			// delete entries older than 365 days in small batches
			// ml_ts has MediaWiki-formatted timestamps, e.g. 20170101000000
			$dbw->query( "DELETE FROM multilookup WHERE ml_ts < NOW() - INTERVAL $maxDays DAY LIMIT 5000", __FILE__ );
			$affectedRows = $dbw->affectedRows();

			$rows += $affectedRows;

			wfWaitForSlaves( $dbw->getDBname() );

			$this->output( '.' );
		} while ( $affectedRows > 0 );

		$this->output( "Deleted $rows from specials.multilookup table" );
	}
}

$maintClass = PurgeOldMultiLookupRows::class;
require_once RUN_MAINTENANCE_IF_MAIN;
