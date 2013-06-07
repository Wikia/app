<?php

// example: SERVER_ID=5915 php maintenance/wikia/GoogleWebmasterToolsSync/initial_sync.php --conf /usr/wikia/docroot/wiki.factory/LocalSettings.php

global $IP;
require_once( __DIR__."/configure_log_file.php" );
GWTLogHelper::notice( __FILE__ . " script starts.");
$minCountOfPagesToSync = 100;

try {
	global $wgExternalSharedDB, $wgDatamartDB;

	$wikiPageCountService = (new WikiPageCountServiceFactory())->get();
	$wikiRepository = new GWTWikiRepository();

	foreach ( Iterators::group( $wikiPageCountService->listPageCountsIterator(), 50 ) as $pageCountGroup ) {

		GWTLogHelper::debug( "Group size: " . count( $pageCountGroup ) );
		foreach ( $pageCountGroup as $pageCountModel ) {
			/** @var WikiPageCountModel $pageCountModel */
			$page = $wikiRepository->oneByWikiId( $pageCountModel->getWikiId() );
			if( $page == null ) {
				$wikiRepository->insert( $pageCountModel->getWikiId(), null, null, $pageCountModel->getPageCount() );
			} else {
				if ( $page->getPageCount() != $pageCountModel->getPageCount() ) {
					$page->setPageCount( $pageCountModel->getPageCount() );
					$wikiRepository->updateWiki( $page );
				}
			}
		}
		sleep(1);
	}
	GWTLogHelper::notice( __FILE__ . " script ends.");

} catch ( Exception $ex ) {
	GWTLogHelper::error( __FILE__ . " script failed.", $ex);
}
