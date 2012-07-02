<?php
/**
 * Maintenance script to populate the globalimagelinks table. Needs to be run
 * on all wikis.
 */
$path = dirname( dirname( dirname( __FILE__ ) ) );

if ( getenv( 'MW_INSTALL_PATH' ) !== false ) {
	$path = getenv( 'MW_INSTALL_PATH' );
}

require_once( $path . '/maintenance/Maintenance.php' );

class RefreshGlobalImageLinks extends Maintenance {
	public function __construct() {
		parent::__construct();
		$this->addOption( 'start-page', 'page_id of the page to start with' );
		$this->addOption( 'start-image', 'il_to of the image to start with' );
		$this->addOption( 'maxlag', 'Maximum replication lag', false, true );
	}

	public function execute() {
		global $wgGlobalUsageDatabase;

		$dbr = wfGetDB( DB_SLAVE );
		$dbw = wfGetDB( DB_MASTER, array(), $wgGlobalUsageDatabase );
		$gu = new GlobalUsage( wfWikiId(), $dbw );

		$lastPageId = intval( $this->getOption( 'start-page', 0 ) );
		$lastIlTo = $this->getOption( 'start-image' );
		$limit = 500;
		$maxlag = intval( $this->getOption( 'maxlag', 5 ) );

		do {
			$this->output( "Querying links after (page_id, il_to) = ($lastPageId, $lastIlTo)\n" );

			# Query all pages and any imagelinks associated with that
			$quotedLastIlTo = $dbr->addQuotes( $lastIlTo );
			$res = $dbr->select(
				array( 'page', 'imagelinks', 'image' ),
				array(
					'page_id', 'page_namespace', 'page_title',
					'il_to', 'img_name'
				),
				"(page_id = $lastPageId AND il_to > {$quotedLastIlTo})" .
						" OR page_id > $lastPageId",
				__METHOD__,
				array(
					'ORDER BY' => $dbr->implicitOrderBy() ? 'page_id' : 'page_id, il_to',
					'LIMIT' => $limit
				),
				array(
					# LEFT JOIN imagelinks since we need to delete usage
					# from all images, even if they don't have images anymore
					'imagelinks' => array( 'LEFT JOIN', 'page_id = il_from' ),
					# Check to see if images exist locally
					'image' => array( 'LEFT JOIN', 'il_to = img_name' )
				)
			);

			# Build up a tree per pages
			$pages = array();
			$lastRow = null;
			foreach ( $res as $row ) {
				if ( !isset( $pages[$row->page_id] ) )
					$pages[$row->page_id] = array();
				# Add the imagelinks entry to the pages array if the image
				# does not exist locally
				if ( !is_null( $row->il_to ) && is_null( $row->img_name ) ) {
					$pages[$row->page_id][$row->il_to] = $row;
				}
				$lastRow = $row;
			}

			# Insert the imagelinks data to the global table
			foreach ( $pages as $pageId => $rows ) {
				# Delete all original links if this page is not a continuation
				# of last iteration.
				if ( $pageId != $lastPageId )
					$gu->deleteLinksFromPage( $pageId );
				if ( $rows ) {
					$title = Title::newFromRow( reset( $rows ) );
					$images = array_keys( $rows );
					# Since we have a pretty accurate page_id, don't specify
					# Title::GAID_FOR_UPDATE
					$gu->insertLinks( $title, $images, /* $flags */ 0 );
				}
			}

			if ( $lastRow ) {
				# We've processed some rows in this iteration, so save
				# continuation variables
				$lastPageId = $lastRow->page_id;
				$lastIlTo = $lastRow->il_to;

				# Be nice to the database
				$dbw->commit();
				wfWaitForSlaves( $maxlag, $wgGlobalUsageDatabase );
			}
		} while ( !is_null( $lastRow ) );
	}
}

$maintClass = 'RefreshGlobalImageLinks';
require_once( DO_MAINTENANCE );
