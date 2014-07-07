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

class ReviewAllPages extends Maintenance {

	public function __construct() {
		parent::__construct();
		$this->mDescription = "Review all pages in reviewable namespaces. " .
			"A user ID must be given to specifiy the \"reviewer\" who accepted the pages.";
		$this->addOption( 'username',
			'The user name of the existing user to use as the "reviewer"', true, true );
		$this->setBatchSize( 100 );
	}

	public function execute() {
		$user = User::newFromName( $this->getOption( 'username' ) );
		$this->autoreview_current( $user );
	}

	protected function autoreview_current( User $user ) {
		$this->output( "Auto-reviewing all current page versions...\n" );
		if ( !$user->getID() ) {
			$this->output( "Invalid user specified.\n" );
			return;
		} elseif ( !$user->isAllowed( 'review' ) ) {
			$this->output( "User specified (id: {$user->getID()}) does not have \"review\" rights.\n" );
			return;
		}

		$db = wfGetDB( DB_MASTER );

		$this->output( "Reviewer username: " . $user->getName() . "\n" );

		$start = $db->selectField( 'page', 'MIN(page_id)', false, __METHOD__ );
		$end = $db->selectField( 'page', 'MAX(page_id)', false, __METHOD__ );
		if ( is_null( $start ) || is_null( $end ) ) {
			$this->output( "...page table seems to be empty.\n" );
			return;
		}
		# Do remaining chunk
		$end += $this->mBatchSize - 1;
		$blockStart = $start;
		$blockEnd = $start + $this->mBatchSize - 1;
		$count = 0;
		$changed = 0;
		$flags = FlaggedRevs::quickTags( FR_CHECKED ); // Assume basic level

		while ( $blockEnd <= $end ) {
			$this->output( "...doing page_id from $blockStart to $blockEnd\n" );
			$res = $db->select( array( 'page', 'revision' ),
				'*', 
				array( "page_id BETWEEN $blockStart AND $blockEnd",
					'page_namespace' => FlaggedRevs::getReviewNamespaces(),
					'rev_id = page_latest' ),
				__METHOD__
			);
			# Go through and autoreview the current version of every page...
			foreach ( $res as $row ) {
				$title = Title::newFromRow( $row );
				$rev = Revision::newFromRow( $row );
				# Is it already reviewed?
				$frev = FlaggedRevision::newFromTitle( $title, $row->page_latest, FR_MASTER );
				# Rev should exist, but to be safe...
				if ( !$frev && $rev ) {
					$article = new Article( $title );
					$db->begin();
					FlaggedRevs::autoReviewEdit( $article, $user, $rev, $flags, true );
					FlaggedRevs::HTMLCacheUpdates( $article->getTitle() );
					$db->commit();
					$changed++;
				}
				$count++;
			}
			$db->freeResult( $res );
			$blockStart += $this->mBatchSize - 1;
			$blockEnd += $this->mBatchSize - 1;

			// XXX: Don't let deferred jobs array get absurdly large (bug 24375)
			DeferredUpdates::doUpdates( 'commit' );

			wfWaitForSlaves( 5 );
		}

		$this->output( "Auto-reviewing of all pages complete ..." .
			"{$count} rows [{$changed} changed]\n" );
	}
}

$maintClass = "ReviewAllPages";
require_once( RUN_MAINTENANCE_IF_MAIN );
