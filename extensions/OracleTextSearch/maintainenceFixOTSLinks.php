<?php
if ( getenv( 'MW_INSTALL_PATH' ) !== false ) {
	$IP = getenv( 'MW_INSTALL_PATH' );
} else {
	$dir = dirname( __FILE__ ); 
	$IP = "$dir/../..";
}
require_once( "$IP/maintenance/Maintenance.php" );

class FixOTSLinks extends Maintenance {
	public function __construct() {
		parent::__construct();
		$this->mDescription = "Fix oracle text index links for documents";
		$this->addOption( 'all', 'Update all links (not only missing ones)' );
	}

	public function execute() {
		$doAll = $this->hasOption( 'all' );
		if ($doAll) {
			$this->output( "Recreating all index links to documents\n" );
		} else {
			$this->output( "Recreating missing index links to documents\n" );
		}
		$this->doRecreate($doAll);
	}

	private function doRecreate($all) {
		global $wgExIndexMIMETypes, $wgExIndexOnHTTP;
		$dbw = wfGetDB( DB_MASTER );

		$tbl_pag = $dbw->tableName( 'page' );
		$tbl_idx = $dbw->tableName( 'searchindex' );
		
		$searchWhere = $all ? '' : ' AND NOT EXISTS (SELECT null FROM '.$tbl_idx.' WHERE si_page=p.page_id AND si_url IS NOT null)';
		$result = $dbw->query('SELECT p.page_id FROM '.$tbl_pag.' p WHERE p.page_namespace = '.NS_FILE.$searchWhere );
		$this->output( $result->numRows()." file(s) found\n" );
		
		$syncIdx = false;
		$countDone = 0;
		$countSkipped = 0;

		while (($row = $result->fetchObject()) !== false) {
			$titleObj = Title::newFromID($row->page_id);
			$file = wfLocalFile($titleObj->getText());

			if (in_array( $file->getMimeType(), $wgExIndexMIMETypes )) {
				$url = $wgExIndexOnHTTP ? preg_replace( '/^https:/i', 'http:', $file->getFullUrl() ) : $file->getFullUrl();
				$dbw->update('searchindex',
					array( 'si_url' => $url ), 
					array( 'si_page' => $row->page_id ),
					'SearchIndexUpdate:update' );
				$syncIdx = true;
			} else {
				$countSkipped++;
			}
			$countDone++;
		}
		
		if ( $syncIdx ) {
			$this->output( "Syncing index... " );
			$index = $dbw->getProperty('mTablePrefix')."si_url_idx";
			$dbw->query( "CALL ctx_ddl.sync_index('$index')" );
			$this->output( "Done\n" );
		}
		
		$this->output("Finished ($countDone processed" );
		if ( $countSkipped > 0 ) {
			$this->output(", $countSkipped skipped " );
		}
		$this->output(")\n" );
	}
}

$maintClass = "FixOTSLinks";
require_once( DO_MAINTENANCE );

