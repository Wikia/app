
<?php
/**
 * removeVideoTitleCategories.php
 *
 * This script removes categories added to ingested videos which are the same as the video title.
 *
 * @author james@wikia-inc.com
 * @ingroup Maintenance
 */

ini_set( 'display_errors', 'stderr' );
ini_set( 'error_reporting', E_NOTICE );

require_once( dirname( __FILE__ ) . '/../../Maintenance.php' );

/**
 * Class removeVideoTitleCategories
 */
class removeVideoTitleCategories extends Maintenance {


	const EDIT_MESSAGE = "Removing categories from file pages with same name as the video title";

	protected $verbose      = false;
	protected $dryRun       = false;
	protected $pagesUpdated = 0;
	protected $pagesSkipped = 0;

	public function __construct() {
		parent::__construct();
		$this->mDescription = 'Remove categories from file pages which have the same name as the video';
		$this->addOption( 'dry-run', 'Dry run; make no changes', false, false, 'd' );
		$this->addOption( 'verbose', 'Show extra debugging output', false, false, 'v' );
	}

	public function execute() {
		$this->dryRun  = $this->hasOption( 'dry-run' );
		$this->verbose = $this->hasOption( 'verbose' );

		if ( $this->dryRun ) {
			$this->log( "Dry run. No changes will be made\n------------------" );
		}

		$titles = $this->getVideoTitles();
		$this->deleteCategoryFromPage( $titles );
		$this->printSummary();
	}

	/**
	 * Delete category with the same name as title from the file page.
	 * @param $titles
	 */
	public function deleteCategoryFromPage( $titles ) {
		foreach ( $titles as $title ) {
			$titleObj = Title::newFromText( $title, NS_FILE );
			$titleName = $titleObj->getText();
			$escapedCategoryTag = preg_quote( "[[Category:"  . $titleName . "]]" );
			$article = Article::newFromID( $titleObj->getArticleID() );
			$content = $article->getContent();
			$contentMinusCategory = preg_replace( "/$escapedCategoryTag/", "", $content );

			// Check if there really was a category to remove from the page
			if ( $contentMinusCategory != $content ) {
				if ( !$this->dryRun ) {
					$article->doEdit( $contentMinusCategory, self::EDIT_MESSAGE, EDIT_UPDATE | EDIT_SUPPRESS_RC | EDIT_FORCE_BOT );
				}
				$this->pagesUpdated++;
				$this->log("Updated $titleName");
			} else {
				$this->pagesSkipped++;
				$this->log( "Inconsistency in database, $titleName does not have category of same name in page content" );
			}
		}

	}

	/**
	 * Get a list of video files which have a category associated with the exact same name
	 * (eg a video with a title of "The Voice Interview Excerpts Cathia" with a category of that name as well).
	 * @return array
	 */
	public function getVideoTitles() {
		$db = wfGetDB( DB_SLAVE );
		$titles = ( new WikiaSQL() )->SELECT( "cl_to" )
			->FROM( "categorylinks" )
			->JOIN( "page" )
			->ON( "cl_to", "page_title" )
			->AND_( "cl_from", "page_id" )
			->WHERE( "page_namespace" )->EQUAL_TO( NS_FILE )
			->runLoop( $db, function ( &$titles, $row ) {
				$titles[] = $row->cl_to;
			});

		return $titles;
	}

	public function log( $msg ) {
		if ( $this->verbose ) {
			echo $msg . "\n";
		}
	}

	public function printSummary() {
		echo "Done\n";
		echo "------------------\n";
		echo $this->pagesUpdated . " pages updated\n";
		echo $this->pagesSkipped . " pages skipped\n";
	}

}

$maintClass = "removeVideoTitleCategories";
require_once( RUN_MAINTENANCE_IF_MAIN );
