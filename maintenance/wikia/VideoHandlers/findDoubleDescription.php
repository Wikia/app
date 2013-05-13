<?php
/**
 * Find double description headers
 *
 * @author garth@wikia-inc.com
 * @ingroup Maintenance
 */

ini_set('display_errors', 'stderr');
ini_set('error_reporting', E_NOTICE);

require_once( dirname( __FILE__ ) . '/../../Maintenance.php' );

class EditCLI extends Maintenance {
	public function __construct() {
		parent::__construct();
		$this->mDescription = "Find double description headers";
		$this->addOption( 'pageid', 'Page ID', false, true, 'p' );
	}

	public function execute() {
		global $wgTitle;

		$pageID = $this->getOption( 'pageid' );
		if ( !empty($pageID) ) {
			echo "Scaning page ID $pageID\n";
			$this->scanArticle($pageID);
			exit(0);
		}

		$dbs = wfGetDB(DB_SLAVE);
		if (is_null($dbs)) {
			exit(1);
		}

		# Find all video file pages
		$query = "select page_id " .
				 "from page join video_info " .
				 "  on video_title=page_title " .
				 "where page_namespace = 6";
		$res = $dbs->query($query);

		while ($row = $dbs->fetchObject($res)) {
			$pageId = $row->page_id;

			$this->scanArticle($pageId);
		}
		$dbs->freeResult($res);
	}

	public function scanArticle ( $pageId ) {
		$wgTitle = Title::newFromID( $pageId );
		if ( !$wgTitle ) {
			$this->error( "Invalid title", true );
		}

		$page = WikiPage::factory( $wgTitle );

		# Read the text
		$text = $page->getText();
		if (preg_match('/^== *description *==.+^== *description *==/sim', $text)) {
			echo "\t($pageId) ".$wgTitle->getFullURL()."\n";
		}
	}
}

$maintClass = "EditCLI";
require_once( RUN_MAINTENANCE_IF_MAIN );

