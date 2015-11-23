<?php
/**
 * fixCommentIndexes
 *
 * This script fixes the issue where the same comment index number is used on multiple comments, e.g. the #2 fragment
 * in the URL:
 *
 * http://creepypasta.wikia.com/wiki/Thread:510920#2
 *
 */

ini_set('display_errors', 'stderr');
ini_set('error_reporting', E_NOTICE);

require_once( dirname( __FILE__ ) . '/../../Maintenance.php' );

/**
 * Class FSCKVideos
 */
class FixCommentIndexes extends Maintenance {

	// Give a buffer for the new comment index we use in case the thread is actively being commented on
	const RACE_BUFFER = 100;

	protected $verbose = false;
	protected $test    = false;

	public function __construct() {
		parent::__construct();
		$this->mDescription = "Pre-populate LVS suggestions";
		$this->addOption( 'test', 'Test mode; make no changes', false, false, 't' );
		$this->addOption( 'verbose', 'Show extra debugging output', false, false, 'v' );
	}

	public function execute() {
		$this->test    = $this->hasOption( 'test' );
		$this->verbose = $this->hasOption( 'verbose' );

		echo "Fixing ".$this->getWikiName()."\n";

		if ( $this->test ) {
			echo "== TEST MODE ==\n";
		}
		$this->debug( "(debugging output enabled)\n" );

		// This is needed for some of the operations that follow
		F::app()->wg->Title = SpecialPage::getTitleFor( 'Forum' );

		$threads = $this->getAffectedThreads();
		$this->debug( 'Found '.count($threads)." threads to fix\n" );

		foreach ( $threads as $threadId ) {
			$this->fixThread( $threadId );
		}
	}

	private function fixThread( $threadId ) {
		$this->debug( "* Fixing thread $threadId\n" );

		$commentCount = $this->getCommentCount( $threadId );

		if ( !$this->test ) {
			wfSetWikiaPageProp( WPP_WALL_COUNT, $threadId, $commentCount + self::RACE_BUFFER );
		}

		$this->debug( "-- Found $commentCount comments\n");
		$this->debug( "-- Renumbering ... ");
		$this->renumberComments( $threadId );
		$this->debug( "done\n" );
	}

	private function renumberComments( $threadId ) {
		$comments = $this->getCommentIds( $threadId );
		$commentIdx = 2;

		if ( $this->test ) {
			return;
		}

		foreach ( $comments as $commentId ) {
			wfSetWikiaPageProp( WPP_WALL_COUNT, $commentId, $commentIdx++ );
		}
	}

	private function getCommentIds( $threadId ) {
		$dbr = wfGetDB( DB_SLAVE );
		$comments = (new WikiaSQL)
			->SELECT( 'comment_id' )
			->FROM( 'comments_index' )
			->WHERE( 'parent_comment_id' )->EQUAL_TO( $threadId )
			->runLoop( $dbr, function ( &$comments, $row ) {
				$comments[] = $row->comment_id;
			});

		return $comments;
	}

	private function getCommentCount( $threadId ) {
		$dbr = wfGetDB( DB_SLAVE );
		$count = (new WikiaSQL)
			->SELECT( 'count(*)' )->AS_( 'cnt' )
			->FROM( 'comments_index' )
			->WHERE( 'parent_comment_id' )->EQUAL_TO( $threadId )
			->run( $dbr, function ( $result ) {
				$row = $result->fetchObject();
				if ( empty( $row ) ) {
					return 0;
				}

				return $row->cnt;
			});

		return $count;
	}

	/**
	 *
	 *
	 * @return array
	 */
	private function getAffectedThreads() {
		$dbr = wfGetDB( DB_SLAVE );
		$threads = (new WikiaSQL)
			->SELECT( 'parent_comment_id', 'props', 'count(*)' )
			->FROM( 'comments_index' )
			->JOIN( 'page_wikia_props' )
			->WHERE( 'page_id' )->EQUAL_TO_FIELD( 'comment_id' )
			->AND_( 'propname' )->EQUAL_TO( WPP_WALL_COUNT )
			->AND_( 'parent_comment_id' )->NOT_EQUAL_TO( 0 )
			->AND_( 'deleted' )->EQUAL_TO( 0 )
			->AND_( 'removed' )->EQUAL_TO( 0 )
			->AND_( 'archived' )->EQUAL_TO( 0 )
			->GROUP_BY( 'parent_comment_id, props' )
			->HAVING( 'count(*)' )->GREATER_THAN( 1 )
			->runLoop( $dbr, function ( &$threads, $row ) {
				$threads[] = $row->parent_comment_id;
			});

		return $threads;
	}

	private function getWikiName() {
		$dbName = WikiFactory::IDtoDB( F::app()->wg->CityId );
		return WikiFactory::DBtoDomain( $dbName );
	}

	/**
	 * Print the message if verbose is enabled
	 * @param $msg - The message text to echo to STDOUT
	 */
	private function debug( $msg ) {
		if ( $this->verbose ) {
			echo $msg;
		}
	}
}

$maintClass = "FixCommentIndexes";
require_once( RUN_MAINTENANCE_IF_MAIN );
