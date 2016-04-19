<?php
/**
 * fixCommentIndexes
 *
 * Jira:
 *
 * Ticket for this fix: https://wikia-inc.atlassian.net/browse/SOC-1485
 * Ticket that caused the problem: https://wikia-inc.atlassian.net/browse/PLATFORM-1658
 *
 * This script fixes the issue where the same comment index number is used on multiple comments, e.g. the #2 in
 * the fragment portion of this URL:
 *
 *   http://creepypasta.wikia.com/wiki/Thread:510920#2
 *
 * For example, the URLs for 5 comments on a thread might be broken in this way:
 *
 *   http://creepypasta.wikia.com/wiki/Thread:510920#2
 *   http://creepypasta.wikia.com/wiki/Thread:510920#3
 *   http://creepypasta.wikia.com/wiki/Thread:510920#4
 *   http://creepypasta.wikia.com/wiki/Thread:510920#4
 *   http://creepypasta.wikia.com/wiki/Thread:510920#4
 *
 * where the same index, #4, has been used for three comments.  The fix would be to update the index for each of
 * these comments (stored in the page_wikia_props table) to be unique, e.g.:
 *
 *   http://creepypasta.wikia.com/wiki/Thread:510920#2
 *                                               ...#3
 *                                               ...#4
 *                                               ...#5
 *                                               ...#6
 *
 * Its possible that this streak of duplicates can happen within normally numbered comments.  This is because
 * we released a fix for the problem before creating this script.  In this case all comments after the duplicate
 * streak will be renumbered and have different URLs than they did previously.  Community has OK'ed this choice.
 *
 */

ini_set('display_errors', 'stderr');
ini_set('error_reporting', E_NOTICE);

require_once( dirname( __FILE__ ) . '/../../Maintenance.php' );

class FixCommentIndexes extends Maintenance {
	static protected $verbose = false;
	static protected $test = false;

	public function __construct() {
		parent::__construct();
		$this->mDescription = "Fix duplicate comment URL problems on Wall and Forum posts";
		$this->addOption( 'test', 'Test mode; make no changes', $required = false, $withArg = false, 't' );
		$this->addOption( 'verbose', 'Show extra debugging output', $required = false, $withArg = false, 'v' );
		$this->addOption( 'thread', 'Specify a thread to fix', $required = false, $withArg = true );
	}

	static public function isVerbose() {
		return self::$verbose;
	}

	static public function isTest() {
		return self::$test;
	}

	/**
	 * Print the message if verbose is enabled
	 *
	 * @param $msg - The message text to echo to STDOUT
	 */
	static public function debug( $msg ) {
		if ( self::isVerbose() ) {
			echo $msg;
		}
	}

	public function execute() {
		self::$test = $this->hasOption( 'test' );
		self::$verbose = $this->hasOption( 'verbose' );
		$thread = $this->getOption( 'thread' );

		echo "Fixing " . self::getWikiURL() . "\n";

		if ( self::isTest() ) {
			echo "== TEST MODE ==\n";
		}
		$this->debug( "(debugging output enabled)\n" );

		// A current Title object is needed for some of the operations that follow
		F::app()->wg->Title = SpecialPage::getTitleFor( 'Forum' );

		if ( empty( $thread ) ) {
			$threads = $this->getAffectedThreads();
		} else {
			$threads = [ $thread ];
		}
		$this->debug( 'Found ' . count( $threads ) . " threads to fix\n" );

		foreach ( $threads as $threadId ) {
			$brokenThread = new BrokenThread( $threadId );
			$brokenThread->fix();
		}
	}

	/**
	 * Find the list of threads with children that have duplicated values in the props field
	 * of page_wikia_props.  This indicates the counter has been reused by more than one comment
	 * in the same thread.  We ignore deleted, removed and archived comments since those are likely
	 * to have duplicates with current comments because the author of that code never considered
	 * un-deleting/removing/archiving as a thing.  Not going to fix that here since who knows what
	 * additional bugs that will uncover.
	 *
	 * @return array
	 */
	private function getAffectedThreads() {
		$dbr = wfGetDB( DB_SLAVE );
		$threads = ( new WikiaSQL )
			->SELECT( 'parent_comment_id', 'props', 'count(*)' )
			->FROM( 'comments_index' )
			->JOIN( 'page_wikia_props' )
			->WHERE( 'page_id' )->EQUAL_TO_FIELD( 'comment_id' )
			->AND_( 'propname' )->EQUAL_TO( WPP_WALL_COUNT )
			->AND_( 'parent_comment_id' )->NOT_EQUAL_TO( 0 )
			->AND_( 'removed' )->EQUAL_TO( 0 )
			->AND_( 'deleted' )->EQUAL_TO( 0 )
			->AND_( 'archived' )->EQUAL_TO( 0 )
			->GROUP_BY( 'parent_comment_id, props' )
			->HAVING( 'count(*)' )->GREATER_THAN( 1 )
			->runLoop( $dbr, function ( &$threads, $row ) {
				$threads[] = $row->parent_comment_id;
			} );

		// Ensure that we're always sending an array back
		return empty( $threads ) ? [ ] : $threads;
	}

	/**
	 * Get the URL for the wiki being worked on by this script
	 *
	 * @return string
	 */
	static public function getWikiURL() {
		$dbName = WikiFactory::IDtoDB( F::app()->wg->CityId );
		$url = WikiFactory::DBtoDomain( $dbName );
		return WikiFactory::getLocalEnvURL( 'http://'.$url );
	}
}

class BrokenThread {

	private $threadId;

	/**
	 * @param int $threadId
	 */
	public function __construct( $threadId ) {
		$this->threadId = $threadId;
	}

	/**
	 * Fix the comment numbering for the thread given by $this->threadId
	 */
	public function fix() {
		FixCommentIndexes::debug( "* Fixing thread ".$this->threadId."\n" );

		// Set the wall count immediately so that any comments made while executing renumberComments
		// will get the correct index
		$this->setNewWallCount();
		$this->renumberComments();
	}

	/**
	 * Sets the new index to use whenever the next comment is made on the current thread
	 */
	private function setNewWallCount() {
		$dbw = wfGetDB( DB_MASTER );

		// Construct a statement that will return a PHP serialized integer count of comments
		$countSQL = ( new WikiaSQL() )
			->SELECT( "concat('i:', count(*)+1, ';')" )
			->FROM( 'comments_index' )
			->WHERE( 'parent_comment_id' )->EQUAL_TO( $this->threadId );

		// Issue an update with the above sub-select included to atomically update page_wikia_props
		$updateSQL = ( new WikiaSQL() )
			->UPDATE( 'page_wikia_props' )
			->SET_RAW( 'props', '('.$countSQL->__toString().')' )
			->WHERE( 'page_id' )->EQUAL_TO( $this->threadId );

		if ( !FixCommentIndexes::isTest() ) {
			$updateSQL->run( $dbw );
		}
	}

	/**
	 * Update the comment number used for creating links to those comments.  It doesn't matter what they are
	 * as long as each comment has a unique number, however ascending from 2 is how it works now and makes the
	 * most sense.
	 */
	private function renumberComments() {
		$comments = $this->getCommentIds();

		// Output some info if we're verbose.
		FixCommentIndexes::debug( "-- ".$this->getThreadURL()."\n" );
		FixCommentIndexes::debug( "-- Found ".count($comments)." comments\n" );
		FixCommentIndexes::debug( "-- Renumbering ... " );

		$commentIdx = 2;

		foreach ( $comments as $commentId ) {
			if ( !FixCommentIndexes::isTest() ) {
				wfSetWikiaPageProp( WPP_WALL_COUNT, $commentId, $commentIdx++ );
			}
		}

		FixCommentIndexes::debug( " done\n" );
	}

	/**
	 * Get the URL for the thread
	 *
	 * @return String
	 */
	private function getThreadURL() {
		$baseURL = FixCommentIndexes::getWikiURL();
		return $baseURL . '/wiki/Thread:'.$this->threadId;
	}

	/**
	 * Get the list of comments made on the thread given by $threadId.  Order by comment ID which should return
	 * them in chronological order.  Its not the end of the world if they aren't but it will make the renumbering
	 * more sensible.
	 *
	 * @return array
	 */
	private function getCommentIds() {
		$dbr = wfGetDB( DB_SLAVE );
		$comments = ( new WikiaSQL )
			->SELECT( 'comment_id' )
			->FROM( 'comments_index' )
			->WHERE( 'parent_comment_id' )->EQUAL_TO( $this->threadId )
			->ORDER_BY( 'comment_id' )
			->runLoop( $dbr, function ( &$comments, $row ) {
				$comments[] = $row->comment_id;
			});

		// Ensure that we're always sending an array back
		return empty( $comments ) ? [] : $comments;
	}
}

$maintClass = "FixCommentIndexes";
require_once( RUN_MAINTENANCE_IF_MAIN );
