<?php

require_once( __DIR__ . '/../Maintenance.php' );

class reindexImagesForWiki extends Maintenance {

	public function __construct() {
		parent::__construct();
		$this->mDescription = "Run ImageServingHelper::buildAndGetIndex() and clear memory cache for wiki to index images and update page_wikia_props table";
		$this->addOption( 'articleID', 'Id of article', false, true, 'a' );
	}

	public function execute() {

		global $wgServer, $wgCityId;

		$articleID = $this->getOption( 'articleID', 0 );
		$dbName = WikiFactory::IDtoDB( $wgCityId );
		$db = wfGetDB( DB_SLAVE, $dbName );

		$this->output( "\nTable page_wikia_props will be updated for {$wgServer} wiki \n\n" );

		if ( !$articleID ) {

			$articles = $db->select(
				[ "page" ],
				[ "page_id" ],
				[
					"page_namespace = 0 OR page_namespace = 1",
					"page_title NOT LIKE '%@comment%'"
				]
			);

			while ( $row = $db->fetchRow( $articles ) ) {
				$pageId = $row[ 'page_id' ];
				$this->rebuildIndex( $pageId );
			}

		} else {
			$this->rebuildIndex( $articleID );
		}

		$this->output( "\nTable page_wikia_props updated\n\n" );
		return 0;
	}

	private function rebuildIndex( $pageId ) {

		$article = Article::newFromID( $pageId );
		ImageServingHelper::buildAndGetIndex( $article, true );

		$this->output( "\nTable updated for article with id {$pageId}\n\n" );

	}

}

$maintClass = "reindexImagesForWiki";
require_once( RUN_MAINTENANCE_IF_MAIN );
