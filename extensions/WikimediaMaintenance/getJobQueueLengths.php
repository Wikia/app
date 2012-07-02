<?php

/**
 * Get the length of the job queue on all wikis in $wgConf
 */

require_once( dirname( __FILE__ ) .'/WikimediaMaintenance.php' );

class GetJobQueueLengths extends WikimediaMaintenance {
	function __construct() {
		parent::__construct();
		$this->mDescription = 'Get the length of the job queue on all wikis in $wgConf';
	}

	function execute() {
		global $wgConf;
		foreach ( $wgConf->getLocalDatabases() as $wiki ) {
			$lb = wfGetLB( $wiki );
			$db = $lb->getConnection( DB_MASTER, array(), $wiki );
			$count = intval( $db->selectField( 'job', 'COUNT(*)', '', __METHOD__ ) );
			$this->output( "$wiki $count\n" );
			$lb->reuseConnection( $db );
		}
	}
}

$maintClass = 'GetJobQueueLengths';
require_once( DO_MAINTENANCE );
