<?php
require_once( dirname( __FILE__ ) . '/WikimediaMaintenance.php' );

class CleanupBug31576 extends WikimediaMaintenance {
	public function __construct() {
		parent::__construct();
		$this->mDescription = "Cleans up templatelinks corruption caused by https://bugzilla.wikimedia.org/show_bug.cgi?id=31576";
		$this->addOption( 'batchsize', 'Number of rows to process in one batch. Default: 50', false, true );
	}

	public function execute() {
		$this->batchsize = $this->getOption( 'batchsize', 50 );
		$variableIDs = MagicWord::getVariableIDs();
		foreach ( $variableIDs as $id ) {
			$magic = MagicWord::get( $id );
			foreach ( $magic->getSynonyms() as $synonym ) {
				$this->processSynonym( $synonym );
			}
		}
		$this->output( "All done\n" );
	}

	public function processSynonym( $synonym ) {
		$dbr = wfGetDB( DB_SLAVE );
		$pCount = 0;
		$vCount = 0;
		$this->output( "Fixing pages with template links to $synonym ...\n" );
		while ( true ) {
			$res = $dbr->select( 'templatelinks', array( 'tl_title', 'tl_from' ),
				array(
					'tl_namespace' => NS_TEMPLATE,
					'tl_title ' . $dbr->buildLike( $synonym, $dbr->anyString() )
				), __METHOD__,
				array( 'ORDER BY' => array( 'tl_title', 'tl_from' ), 'LIMIT' => $this->batchsize )
			);
			if ( $dbr->numRows( $res ) == 0 ) {
				// No more rows, we're done
				break;
			}

			$processed = array();
			foreach ( $res as $row ) {
				$vCount++;
				if ( isset( $processed[$row->tl_from] ) ) {
					// We've already processed this page, skip it
					continue;
				}
				RefreshLinks::fixLinksFromArticle( $row->tl_from );
				$processed[$row->tl_from] = true;
				$pCount++;
			}
			$this->output( "{$pCount}/{$vCount} pages processed\n" );
			wfWaitForSlaves();
		}
	}

}

$maintClass = "CleanupBug31576";
require_once( RUN_MAINTENANCE_IF_MAIN );
