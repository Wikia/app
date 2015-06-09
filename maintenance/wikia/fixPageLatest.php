<?php

/**
 * Script that tries to fix page_latest entry in page table
 *
 * @author macbre
 * @ingroup Maintenance
 *
 * @see BAC-278
 * @see PLATFORM-1206
 */

require_once( dirname( __FILE__ ) . '/../Maintenance.php' );

/**
 * Maintenance script class
 */
class FixPageLatest extends Maintenance {

	const EMPTY_EDIT_SUMMARY = 'An empty edit for the missing revision';

	/* @var DatabaseBase $dbw */
	private $dbw;
	/* @var User $user */
	private $user;

	/**
	 * Set script options
	 */
	public function __construct() {
		parent::__construct();
		$this->addOption( "dry-run", "Do not update page table" );
		$this->mDescription = 'Fixes page_latest entry in page table';
	}

	/**
	 * @param int $pageId page id to insert the revision for
	 * @return int ID of inserted revisions
	 * @throws MWException
	 */
	private function insertEmptyRevision( $pageId ) {
		$revision = new Revision( [
			'page'       => $pageId,
			'comment'    => self::EMPTY_EDIT_SUMMARY ,
			'minor_edit' => true,
			'text'       => '',
			'user'       => $this->user->getId(),
			'user_text'  => $this->user->getName(),
			'timestamp'  => wfTimestampNow()
		] );

		return $revision->insertOn( $this->dbw );
	}

	public function execute() {
		$isDryRun = $this->hasOption( 'dry-run' );
		$dbr = $this->getDB( DB_SLAVE );

		# select page_id, page_title, page_touched, rev_id from page left join revision on rev_page = page_id where page_latest = 0
		$this->output( 'Looking for pages with broken page_latest entry...' );
		$res = $dbr->select(
			['page', 'revision'],
			[
				'page_id',
				'page_title',
				'page_len',
				# 'page_touched',
				'rev_id'
			],
			['page_latest' => 0],
			__METHOD__,
			[],
			['revision' => ['LEFT JOIN', 'rev_page = page_id']]
		);

		$count = $res->numRows();
		$this->output( " {$count} affected pages(s) found\n\n" );

		if ( $count === 0 ) {
			$this->output( "No articles found!\n" );
			die( 1 );
		}

		// fix entries
		$fixed = 0;

		$this->dbw = $this->getDB( DB_MASTER );
		$this->user = User::newFromName( 'WikiaBot' );

		while ( $row = $res->fetchObject() ) {
			$revId = intval( $row->rev_id );

			if ( $isDryRun ) {
				$this->output( "* {$row->page_title} affected - would set page_latest to {$revId}\n" );
				continue;
			}

			$this->output( "* {$row->page_title}" );

			// no revision data - we can generate an empty revision if "page_len" is set to 0 (PLATFORM-1286)
			if ( $revId == 0 &&  $row->page_len == 0 ) {
				$this->output( " - making an empty edit" );

				try {
					$revId = $this->insertEmptyRevision( $row->page_id );
				}
				catch ( MWException $ex ) {
					$this->output( " - error: " . $ex->getMessage() . "\n" );
					continue;
				}
			}

			$this->dbw->update(
				'page',
				['page_latest' => $revId],
				['page_id' => $row->page_id],
				__METHOD__
			);
			$this->output( " - page_latest set to {$revId}\n" );

			$fixed++;
		}

		if ( !$isDryRun ) {
			$this->output( "Done - {$fixed} page(s) fixed\n" );
		}
	}
}

$maintClass = "FixPageLatest";
require_once( RUN_MAINTENANCE_IF_MAIN );
