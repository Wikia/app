<?php
/**
 * @ingroup Maintenance
 */
if ( getenv( 'MW_INSTALL_PATH' ) ) {
	$IP = getenv( 'MW_INSTALL_PATH' );
} else {
	$IP = dirname(__FILE__).'/../../..';
}

require_once( "$IP/maintenance/Maintenance.php" );

class UpdateFlaggedRevsQueryCache extends Maintenance {

	public function __construct() {
		parent::__construct();
		$this->mDescription = "Update special page query cache table";
	}

	public function execute() {
		$this->output( sprintf( '%-30s ', 'UnreviewedPages' ) );

		$time1 = microtime( true );
		UnreviewedPages::updateQueryCache();
		$time2 = microtime( true );

		$ellapsed = ( $time2 - $time1 );
		$this->output( sprintf( "completed in %.2fs\n", $ellapsed ) );
	}
}

$maintClass = "UpdateFlaggedRevsQueryCache";
require_once( RUN_MAINTENANCE_IF_MAIN );
