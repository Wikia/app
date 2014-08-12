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
 * with parameter type=navigation, e.g.:
 *
 * <gallery type="navigation">
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

require_once( dirname( __FILE__ ) . '/../../Maintenance.php' );

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

		if ( $this->test ) {
			echo "*** TEST MODE ***\n";
		}

		$dbname = WikiFactory::IDtoDB( F::app()->wg->CityId );
		echo "Checking wiki: $dbname\n";

		// Set the user to WikiaBot for methods that need $wgUser
		global $wgUser;
		$wgUser = User::newFromName( 'WikiaBot' );

		$pages = $this->getPages();

		foreach ( $pages as $pageId ) {
			$this->updatePage( $pageId );
		}

		echo "\tUnique gallery params:";
		foreach ( $this->galleryParamTally as $tag => $count ) {
			echo " $tag=$count";
		}
		echo "\n";
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
	 * Update the page given by $pageId adding a type="navigation" parameter on all navigation image galleries.
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

		$text = $article->getContent();

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

		$hasTypeParam = false;

		// Keep a tally of params being used
		if ( preg_match_all( "/([^ =\"']+) *= *[\"']?([^ \"']+)[\"']?/", $galleryParams, $paramMatches ) ) {
			foreach ( $paramMatches[1] as $paramName ) {
				$paramName = strtolower( $paramName );

				if ( empty( $this->galleryParamTally[$paramName] ) ) {
					$this->galleryParamTally[$paramName] = 0;
				}
				$this->galleryParamTally[$paramName]++;

				// Note if a type param is already given.  This indicates we've already acted on this gallery tag in a
				// previous run or its different gallery type (e.g., slider, slideshow)
				if ( $paramName == 'type' ) {
					$hasTypeParam = true;
				}
			}
		}

		// If we have a type param, return this gallery untouched
		if ( $hasTypeParam ) {
			return $matches[0];
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
			return "<gallery$galleryParams type=\"navigation\">\n".trim( $galleryContent )."\n</gallery>";
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

