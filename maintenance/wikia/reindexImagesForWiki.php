<?php

require_once( __DIR__ . '/../Maintenance.php' );

class reindexImagesForWiki extends Maintenance {

	public function __construct() {
		parent::__construct();
		$this->mDescription = "Run ImageServingHelper::buildAndGetIndex() and clear memory cache for wiki to index images and update page_wikia_props table";
		$this->addOption( 'pageID', 'Id of article', false, true, 'p' );
	}

	public function execute() {

		global $wgServer;

		$pageID = $this->getOption( 'pageID', 0 );

		$db = Wikifactory::db( DB_SLAVE );

		$this->output( "\nTable page_wikia_props will be updated for {$wgServer} wiki \n\n" );

		if ( !$pageID ) {

			$articles = $db->select(
				[ 'page_wikia_props' ],
				[ 'page_id' ]
			);

			while ( $row = $db->fetchRow( $articles ) ) {
				$pageId = $row[ 'page_id' ];
				$this->rebuildIndex( $pageId );
			}

		} else {
			$this->rebuildIndex( $pageID );
		}

		$this->output( "\nTable page_wikia_props updated\n\n" );
		return 0;
	}

	private function rebuildIndex( $pageId ) {

		$article = Article::newFromID( $pageId );
		ImageServingHelper::buildAndGetIndex( $article );
		$this->output( "\nTable updated, memory cache keys cleaned for article with id {$pageId}\n\n" );

	}

}

$maintClass = "reindexImagesForWiki";
require_once( RUN_MAINTENANCE_IF_MAIN );
