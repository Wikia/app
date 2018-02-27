<?php

/**
* Maintenance script to migrate urls included in custom JS and CSS files to https/protol relative
* @usage
* 	# this will migrate assets for wiki with ID 119:
*   run_maintenance --script='wikia/HttpsMigration/migrateCustomAseets.php --dryRun' --id=119
*/

ini_set( 'display_errors', 'stderr' );
ini_set( 'error_reporting', E_NOTICE );

require_once( dirname( __FILE__ ) . '/../../Maintenance.php' );

use \Wikia\Logger\WikiaLogger;

/**
 * Class MigrateCustomAssetsToHttps
 */
class MigrateCustomAssetsToHttps extends Maintenance {
	protected $dryRun  = false;

	public function __construct() {
		parent::__construct();
		$this->mDescription = 'Migrates urls in custom assets to HTTPS';
		$this->addOption( 'dryRun', 'Dry run mode', false, false, 'd' );
	}

	public function execute() {
		global $wgCityId;
		$this->dryRun = $this->hasOption('dryRun');
		// dry run ok
		// ale trzeba tez przetestowac zapis
		// kto edytuje
		// change description
		// czy ta zmiana musi przejsc review?


		$this->output('test');
	}

}

$maintClass = "MigrateCustomAssetsToHttps";
require_once( RUN_MAINTENANCE_IF_MAIN );
