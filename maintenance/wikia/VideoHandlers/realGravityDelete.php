<?php
/**
 * realGravityDelete
 *
 * This script removes all RealGravity videos from a wiki
 *
 */

ini_set('display_errors', 'stderr');
ini_set('error_reporting', E_NOTICE);

require_once( dirname( __FILE__ ) . '/../../Maintenance.php' );

/**
 * Class RealGravityDelete
 */
class RealGravityDelete extends Maintenance {

	protected $verbose = false;
	protected $test    = false;

	public function __construct() {
		parent::__construct();
		$this->mDescription = "Pre-populate LVS suggestions";
		$this->addOption( 'test', 'Test mode; make no changes', false, false, 't' );
		$this->addOption( 'verbose', 'Show extra debugging output', false, false, 'v' );
	}

	public function execute() {
		$this->test    = $this->hasOption('test');
		$this->verbose = $this->hasOption('verbose');

		echo "Deleting from ".F::app()->wg->Server."\n";

		if ( $this->test ) {
			echo "== TEST MODE ==\n";
		}
		$this->debug( "(debugging output enabled)\n" );

		$startTime = time();

		$db = wfGetDB(DB_SLAVE);

		// Find all RealGravity file pages
		$pageIds = (new WikiaSQL())
			->SELECT( 'page_id', 'page_title' )
			->FROM( 'video_info' )
				->JOIN( 'page' )->ON( 'video_title', 'page_title' )
			->WHERE( 'provider' )->EQUAL_TO( 'RealGravity' )
				->AND_( 'premium' )->EQUAL_TO( 1 )
				->AND_( 'page_namespace' )->EQUAL_TO( NS_FILE )
			->runLoop( $db, function( &$ids, $row ) {
				$ids[$row->page_id] = $row->page_title;
			});

		// Iterate through each file page and delete it
		foreach ( $pageIds as $id => $title ) {
			$this->debug( "Found page ID $id:\n" );

			$article = Article::newFromID( $id );
			if ( $article instanceof Article ) {
				$this->debug( "\tDeleting file page ('$title') ... " );

				if ( $this->test ) {
					$res = true;
				} else {
					$suppress = true;
					$res = $article->doDeleteArticle( "Removing RealGravity content", $suppress );
				}

				if ( $res === true ) {
					$this->debug("done\n");
				} else {
					$this->debug("\t-- ERROR\n");
				}
			} else {
				$this->debug("\tNo article found\n");
			}

			// Also remove the video_info row
			$this->debug("\tDeleting video info: ");

			$video = new VideoInfo();
			$video->setVideoTitle( $title );

			if ( !$this->test ) {
				$video->deleteVideo();
			}

			$this->debug("done\n");
		}

		$delta = F::app()->wg->lang->formatTimePeriod( time() - $startTime );
		echo "Finished after $delta\n";
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

$maintClass = "RealGravityDelete";
require_once( RUN_MAINTENANCE_IF_MAIN );
