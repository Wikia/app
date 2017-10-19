<?php
/**
 * Script to mark any gallery with more than one image using link= functionality, e.g.:
 *
 * <gallery>
 * Photo.jpg|link=http://www.foo.com/
 * Photo2.jpg
 * ...
 * </gallery>
 *
 * with parameter navigation="true", e.g.:
 *
 * <gallery navigation="true">
 * Photo.jpg|link=http://www.foo.com/
 * Photo2.jpg
 * ...
 * </gallery>
 *
 * https://wikia-inc.atlassian.net/browse/VID-1877
 *
 * @ingroup Maintenance
 */

ini_set('display_errors', 'stderr');
ini_set('error_reporting', E_NOTICE);

require_once( dirname( __FILE__ ) . '/../../../Maintenance.php' );

class MarkAsNav extends Maintenance {

	var $test;
	var $verbose;
	var $galleryParamTally = [];

	/**
	 * Constructor for this maintenance script class
	 */
	public function __construct() {
		parent::__construct();
		$this->mDescription = "Script to mark galleries using image links";
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

	/**
	 * Return an array of page IDs
	 *
	 * @return bool|mixed
	 */
	public function getPages() {
		$app = F::app();

		$statsdb = wfGetDB( DB_SLAVE, null, $app->wg->StatsDB );
		$pages = (new WikiaSQL())
			->SELECT( 'ct_page_id' )
			->FROM( 'city_used_tags' )
			->WHERE( 'ct_wikia_id' )->EQUAL_TO( $app->wg->CityId )
			->AND_( 'ct_kind' )->EQUAL_TO( 'gallery' )
			->runLoop( $statsdb, function ( &$pages, $row ) {
				$pages[] = $row->ct_page_id;
			} );

		return $pages;
	}

	/**
	 * Update the page given by $pageId adding a navigation="true" parameter on all navigation image galleries.
	 *
	 * @param $pageId
	 */
	public function updatePage( $pageId ) {
		/** @var Article|WikiPage $article */
		$article = Article::newFromID( $pageId );

		$this->debug( "\tChecking article ID: $pageId" );

		if ( !$article ) {
			echo "ERR: Could not find article with ID $pageId\n";
			return;
		}

		// Make
		global $wgTitle;
		$wgTitle = $article->getTitle();

		$text = $article->getContent();

		// Do a quick initial check to see if we're likely to find what we want in here
		if ( strpos( $text, 'link=' ) === false ) {
			return;
		}

		// Update galleries that use links and collect some stats
		$newText = preg_replace_callback( '/< *gallery([^>]*)>([^<]+)< *\/ *gallery *>/', [ $this, 'handleGallery' ], $text );

		// Only update if we've changed something
		if ( $newText != $text ) {
			$this->debug("\t\tFound galleries to update");

			$success = true;

			if ( !$this->test ) {
				$success = $article->doEdit(
					$newText,
					'Marking navigational galleries',
					EDIT_MINOR | EDIT_FORCE_BOT | EDIT_AUTOSUMMARY | EDIT_SUPPRESS_RC
				);
			}

			if ( !$success ) {
				echo "ERR: Failed to save page with update gallery tags\n";
			}
		}
	}

	/**
	 * A function for preg_replace_callback to call.  Takes care of updating any <gallery> tags found.
	 *
	 * @param array $matches
	 *
	 * @return string
	 */
	public function handleGallery( array $matches ) {
		$galleryParams = trim( $matches[1] );
		$galleryContent = trim( $matches[2] );
		$galleryLines = array_filter( explode( "\n", $galleryContent ) );

		if ( preg_match_all( "/([^ =\"']+) *= *[\"']?([^ \"']+)[\"']?/", $galleryParams, $paramMatches ) ) {
			$names = $paramMatches[1];
			$values = $paramMatches[2];

			for ( $idx = 0; $idx < count($names); $idx++ ) {
				$paramName = strtolower( $names[$idx] );
				$paramValue = $values[$idx];

				if ( $paramName == 'navigation' ) {
					return $matches[0];
				}

				if ( $paramName == 'type' && $paramValue == 'slider' ) {
					return $matches[0];
				}
			}
		}

		// Requirements state not to convert galleries that only contain one image
		if ( count($galleryLines) <= 1 ) {
			return $matches[0];
		}

		// Look for any linked images
		$hasLink = false;
		foreach ( $galleryLines as $line ) {
			if ( preg_match( '/\| *link=/', $line ) ) {
				$hasLink = true;
				break;
			}
		}

		if ( $hasLink ) {
			// Return an updated gallery tag if it contains links
			return "<gallery".( empty( $galleryParams ) ? '' : " $galleryParams" )." navigation=\"true\">\n$galleryContent\n</gallery>";
		} else {
			// Return gallery tag unaltered if there are no linked gallery images
			return $matches[0];
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

$maintClass = "MarkAsNav";
require_once( RUN_MAINTENANCE_IF_MAIN );

