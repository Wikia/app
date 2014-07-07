<?php
/**
 * This script precaches parser output related data of pending revs
 *
 * @ingroup Maintenance
 */

if ( getenv( 'MW_INSTALL_PATH' ) ) {
	$IP = getenv( 'MW_INSTALL_PATH' );
} else {
	$IP = dirname(__FILE__).'/../../..';
}

require_once( "$IP/maintenance/Maintenance.php" );

class CachePendingRevs extends Maintenance {

	public function __construct() {
		parent::__construct();
		$this->mDescription = "Cache pending revision data";
	}

	public function execute() {
		global $wgUser;
		$dbr = wfGetDB( DB_SLAVE );
		$ret = $dbr->select(
			array( 'flaggedpages', 'revision', 'page' ),
			array_merge( Revision::selectFields(), array( $dbr->tableName( 'page' ) . '.*' ) ),
			array( 'fp_pending_since IS NOT NULL',
				'page_id = fp_page_id',
				'rev_page = fp_page_id',
				'rev_timestamp >= fp_pending_since'
			),
			__METHOD__,
			array( 'ORDER BY' => 'fp_pending_since DESC' )
		);
		foreach ( $ret as $row ) {
			$title = Title::newFromRow( $row );
			$article = new Article( $title );
			$rev = new Revision( $row );
			// Trigger cache regeneration
			$start = microtime( true );
			FRInclusionCache::getRevIncludes( $article, $rev, $wgUser, 'regen' );
			$elapsed = intval( ( microtime( true ) - $start ) * 1000 );
			$this->cachePendingRevsLog(
				$title->getPrefixedDBkey() . " rev:" . $rev->getId() . " {$elapsed}ms" );
		}
	}

	/**
	 * Log the cache message
	 * @param $msg String The message to log
	 */
	private function cachePendingRevsLog( $msg ) {
		$this->output( wfTimestamp( TS_DB ) . " $msg\n" );
		wfDebugLog( 'cachePendingRevs', $msg );
	}
}

$maintClass = "CachePendingRevs";
require_once( RUN_MAINTENANCE_IF_MAIN );
