<?php

$IP = getenv( 'MW_INSTALL_PATH' );
if ( $IP === false ) {
	$IP = dirname( __FILE__ ) . '/../..';
}
require_once( "$IP/maintenance/Maintenance.php" );

class PopulateShortUrlsTable extends Maintenance {
	public function __construct() {
		parent::__construct();
		$this->mDescription = 'Populates ShortUrls Table with all existing articles';
	}

	private function insertRows( $a ) {
		$dbw = wfGetDB( DB_MASTER );
		$dbw->insert(
			'shorturls',
			$a,
			__METHOD__,
			array( 'IGNORE' )
		);
	}

	// @todo FIXME: Refactor out code in ShortUrl.functions.php so it can be used here
	public function execute() {
		$rowCount = 0;
		$dbr = wfGetDB( DB_SLAVE );

		$last_processed_id = 0;

		while ( true ) {
			$insertBuffer = array();
			$res = $dbr->select(
				'page',
				array( 'page_id', 'page_namespace', 'page_title' ),
				array( 'page_id > ' . $last_processed_id ),
				__METHOD__,
				array( 'LIMIT' => 100, 'ORDER BY' => 'page_id' )
			);
			if ( $res->numRows() == 0 ) {
				break;
			}

			foreach ( $res as $row ) {
				$rowCount++;

				$rowData = array(
					'su_namespace' => $row->page_namespace,
					'su_title' => $row->page_title
				);
				$insertBuffer[] = $rowData;

				$last_processed_id = $row->page_id;
			}

			$this->insertRows( $insertBuffer );
			wfWaitForSlaves(); // 'Kill' lag
			$this->output( $rowCount . " titles done\n" );
		}
		$this->output( "Done\n" );
	}
}

$maintClass = 'PopulateShortUrlsTable';
require_once( DO_MAINTENANCE );
