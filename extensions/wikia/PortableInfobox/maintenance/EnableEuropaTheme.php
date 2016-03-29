<?php

/**
 * Enable Europa Theme on wikis that do not use Portable Infoboxes yet
 * NOT Thread safe! Run only one instance passing arbitrary SERVER_ID, i.e.
 * SERVER_ID=177 php EnableEuropaTheme.php
 *
 * By default runs in dry run mode
 * Do really enable the rows, use --make-changes option
 */

require_once( getenv( 'MW_INSTALL_PATH' ) !== false ? getenv( 'MW_INSTALL_PATH' ) . '/maintenance/Maintenance.php' : dirname( __FILE__ ) . '/../../../../maintenance/Maintenance.php' );

class EnableEuropaTheme extends Maintenance {
	public function __construct() {
		parent::__construct();

		$this->mDescription = 'Enable Europa Theme on wikis that do not use Portable Infoboxes yet';
		$this->addOption( 'make-changes', 'Do real delete. By default performs a dry run.' );
	}

	public function execute() {

		$dryRun = !$this->hasOption( 'make-changes' );

		echo "Starting processing " . ( $dryRun ? "in dry run mode" : "in REAL UPDATE MODE" ) . PHP_EOL;

		$excludedWikis = $this->getWikisUsingInfoboxes();
		echo "Found " . ( count( $excludedWikis ) ) . " wikis with Infobox markup detected" . PHP_EOL;

		$enabledWikis = $this->getEnabledWikis();
		echo "Found " . ( count( $enabledWikis ) ) . " active wikis" . PHP_EOL;

		$wikisToEnable = array_diff( $enabledWikis, $excludedWikis );
		echo "Going to process " . ( count( $wikisToEnable ) ) . " wikis" . PHP_EOL;

		foreach ( $wikisToEnable as $wikiId ) {
			if ( $dryRun ) {
				echo "Dry-processing $wikiId " . PHP_EOL;
			} else {
				echo "Enabling Europa Theme on $wikiId " . PHP_EOL;
				WikiFactory::setVarByName( 'wgEnablePortableInfoboxEuropaTheme', $wikiId, true );
			}
		}

		echo "Processing finished" . PHP_EOL;
	}

	private function getWikisUsingInfoboxes() {
		global $wgStatsDB, $wgStatsDBEnabled;

		if ( empty( $wgStatsDBEnabled ) ) {
			echo "Statsdb is unavailable" . PHP_EOL . PHP_EOL;
			exit( - 1 );
		}

		$dbs = wfGetDB( DB_SLAVE, [ ], $wgStatsDB );
		$query = "select distinct ct_wikia_id from city_used_tags where ct_kind = 'infobox'";
		$result = $dbs->query( $query );
		$wikisUsingInfoboxes = [ ];

		while ( $row = $result->fetchObject() ) {
			$wikisUsingInfoboxes [] = $row->ct_wikia_id;
		}

		$dbs->close();

		return $wikisUsingInfoboxes;
	}

	private function getEnabledWikis() {
		global $wgExternalSharedDB;

		$db = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );
		$query = "select distinct city_id from city_list where city_public = 1";
		$result = $db->query( $query );
		$allEnabledWikis = [ ];

		while ( $row = $result->fetchObject() ) {
			$allEnabledWikis [] = $row->city_id;
		}

		return $allEnabledWikis;
	}

}

$maintClass = 'EnableEuropaTheme';
require_once( RUN_MAINTENANCE_IF_MAIN );
