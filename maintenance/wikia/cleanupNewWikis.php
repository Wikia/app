<?php

/**
 * This script performs a cleanup of newly created wikis
 *
 * It removes revisions that were imported from the starter database
 *
 * @see PLATFORM-1305
 * @see PLATFORM-1306
 *
 * Based on SQL queries from /maintenance/cleanupStarter.sql:

-- Remove page entries for all files since they belong to shared db.
delete from page where page_namespace=6;
delete from revision where rev_id not in (select page_latest from page);
delete from text where old_id not in (select rev_text_id from revision);

 * @author Macbre
 * @ingroup Maintenance
 */

require_once( __DIR__ . '/../Maintenance.php' );

class CleanupNewWikis extends Maintenance {

	const BATCH = 10000; // remove X rows and wait for slaves to catch up

	protected $mDescription = 'This script performs a cleanup of newly created wikis';

	/**
	 * Set script options
	 */
	public function __construct() {
		parent::__construct();
		$this->addOption( 'dry-run', 'Don\'t perform any write operations' );
	}

	/**
	 * Get revisions and texts ID to remove
	 *
	 * @see https://www.mediawiki.org/wiki/Manual:Revision_table
	 * @see https://www.mediawiki.org/wiki/Manual:Text_table#old_id
	 *
	 * SELECT  rev_id,rev_text_id  FROM `revision`  WHERE (rev_timestamp < "20080220235318") AND (rev_id NOT IN (SELECT page_latest FROM page))
	 *
	 * @param string $ts get revisions created before this date
	 * @return array an array containing rev_id and rev_text_id
	 * @throws MWException
	 */
	private function getRevisionsToDelete( $ts ) {
		$dbr = wfGetDB( DB_SLAVE );

		$res = $dbr->select(
			'revision',
			[ 'rev_id', 'rev_text_id' ],
			[
				sprintf( 'rev_timestamp < "%s"', wfTimestamp( TS_MW, $ts ) ), // revisions from before the wiki creation
				'rev_id NOT IN (SELECT page_latest FROM page)',              // do not delete revisions that are the current ones
			],
			__METHOD__
		);

		$ret = [];
		foreach ( $res as $row ) {
			$ret[] = (array) $row;
		}

		return $ret;
	}

	/**
	 * Perform a DELETE on revision and text tables for given set of revisions
	 *
	 * @param DatabaseBase $dbw database handler
	 * @param array $batch set of rev_id and rev_text_id to remove
	 */
	private function deleteBatch( DatabaseBase $dbw, Array $batch ) {
		$revIds  = array_map( function( $item ) { return $item['rev_id'];      } , $batch );
		$textIds = array_map( function( $item ) { return $item['rev_text_id']; } , $batch );

		$dbw->begin();
		$dbw->delete( 'revision', [ 'rev_id' => $revIds  ], __METHOD__ );
		$dbw->delete( 'text',     [ 'old_id' => $textIds ], __METHOD__ );
		$dbw->commit();

		wfWaitForSlaves();
	}

	function execute() {
		global $wgCityId, $wgDBname;
		$isDryRun = $this->hasOption( 'dry-run' );

		// remove revisions created before the wiki creation, i.e. imported from starter
		$wikiCreationDate = WikiFactory::getWikiByID( $wgCityId )->city_created;

		if ( empty( $wikiCreationDate ) ) {
			$this->error( "{$wgDBname} wiki city_created is empty", 1 );
		}

		// get revisions to delete
		$revisions = $this->getRevisionsToDelete( $wikiCreationDate );

		$this->output( sprintf( "Found %d revision(s) to remove from %s (created before %s)\n",
			count( $revisions ), $wgDBname, $wikiCreationDate ) );

		if ( $isDryRun ) {
			return;
		}

		// perform the delete in batches
		$revisions = array_chunk( $revisions, self::BATCH );
		$dbw = wfGetDB( DB_MASTER );

		foreach ( $revisions as $batch ) {
			$this->deleteBatch( $dbw, $batch );
		}

		$this->output( "Done!\n" );
	}
}

$maintClass = "CleanupNewWikis";
require_once( RUN_MAINTENANCE_IF_MAIN );
