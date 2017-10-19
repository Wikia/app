<?php
/**
 * Script to convert any instance of [[Video:...]] to [[File:...]]
 *
 * https://wikia-inc.atlassian.net/browse/VID-1784
 *
 * @ingroup Maintenance
 */

ini_set('display_errors', 'stderr');
ini_set('error_reporting', E_NOTICE);

require_once( dirname( __FILE__ ) . '/../../Maintenance.php' );

class VideoToFile extends Maintenance {

	private $test;
	private $verbose;

	/**
	 * Constructor for this maintenance script class
	 */
	public function __construct() {
		parent::__construct();
		$this->mDescription = "Script to convert [[Video:...]] links to [[File:...]] links";
		$this->addOption( 'test', 'Test', false, false, 't' );
		$this->addOption( 'verbose', 'Verbose', false, false, 'v' );
	}

	/**
	 * Main code block
	 */
	public function execute() {
		$this->test = $this->hasOption( 'test' );
		$this->verbose = $this->hasOption( 'verbose' );

		$start = time();

		if ( $this->test ) {
			echo "*** TEST MODE ***\n";
		}

		$dbname = WikiFactory::IDtoDB( F::app()->wg->CityId );
		echo "Checking wiki: $dbname\n";

		// Set the user to WikiaBot for methods that need $wgUser
		global $wgUser;
		$wgUser = User::newFromName( Wikia::BOT_USER );

		$pages = $this->getPages();

		foreach ( $pages as $pageId ) {
			$this->updatePage( $pageId );
		}

		$elapsed = time() - $start;
		echo "Done: $elapsed s\n";
	}

	public function getPages() {
		$db = wfGetDB( DB_SLAVE );

		// Get a list of pages to check, excluding obvious image links
		$pageIDs = (new WikiaSQL())
			->SELECT( 'DISTINCT il_from' )
			->FROM( 'imagelinks' )
			->WHERE( "lower(il_to) NOT REGEXP '\.(jpg|jpeg|png|gif)$'" )
			->runLoop( $db, function ( &$pages, $row ) {
				$pages[] = $row->il_from;
			});

		return $pageIDs;
	}

	public function updatePage( $pageId ) {
		/** @var Article|WikiPage $article */
		$article = Article::newFromID( $pageId );

		$this->debug( "\tChecking article ID: $pageId" );

		if ( !$article ) {
			echo "ERR: Could not find article with ID $pageId\n";
			return;
		}

		// Some code expects this to be set
		global $wgTitle;
		$wgTitle = $article->getTitle();

		$text = $article->getContent();
		$newText = preg_replace( '/\[\[ *Video *:/i', '[[File:', $text );

		// See if we've actually changed anything
		if ( $text !== $newText ) {
			$this->debug("\t-- Updating links");
			if ( $this->test ) {
				$success = true;
			} else {
				$success = $article->doEdit(
					$newText,
					'Updating Video:TITLE links to File:TITLE links',
					EDIT_MINOR | EDIT_FORCE_BOT | EDIT_AUTOSUMMARY | EDIT_SUPPRESS_RC
				);
			}

			if ( !$success ) {
				echo "ERR: Failed to save page (ID=$pageId) with update gallery tags\n";
			}
		}
	}

	/**
	 * What a handy debug method!
	 *
	 * @param $msg
	 */
	public function debug( $msg ) {
		if ( $this->verbose ) {
			echo $msg."\n";
		}
	}
}

$maintClass = "VideoToFile";
require_once( RUN_MAINTENANCE_IF_MAIN );

