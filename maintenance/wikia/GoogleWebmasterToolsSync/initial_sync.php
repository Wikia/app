<?php

// example: SERVER_ID=5915 php maintenance/wikia/GoogleWebmasterToolsSync/initial_sync.php --conf /usr/wikia/docroot/wiki.factory/LocalSettings.php

global $IP;
require_once( __DIR__."/common.php" );
GWTLogHelper::notice( __FILE__ . " script starts.");
$minCountOfPagesToSync = 100;

try {
	global $wgExternalSharedDB;

	$wikiPageCountService = (new WikiPageCountServiceFactory())->get();
	$wikiRepository = new GWTWikiRepository();

	foreach ( Iterators::group( $wikiPageCountService->listPageCountsIterator(), 50 ) as $pageCountGroup ) {
		$updated = 0; $created = 0; $same = 0;
		GWTLogHelper::debug( "Group size: " . (int) count( $pageCountGroup ) );
		foreach ( $pageCountGroup as $pageCountModel ) {
			/** @var WikiPageCountModel $pageCountModel */
			$page = $wikiRepository->getById( $pageCountModel->getWikiId() );
			if( $page == null ) {
				$wikiRepository->insert( $pageCountModel->getWikiId(), null, null, $pageCountModel->getPageCount() );
				$created++;
			} else {
				if ( $page->getPageCount() != $pageCountModel->getPageCount() ) {
					$page->setPageCount( $pageCountModel->getPageCount() );
					$wikiRepository->updateWiki( $page );
					$updated++;
				} else {
					$same ++;
				}
			}
		}
		GWTLogHelper::debug("Created: $created, Updated $updated, Same: $same");
		sleep(1);
	}
	GWTLogHelper::notice( __FILE__ . " script ends.");

} catch ( Exception $ex ) {
	GWTLogHelper::error( __FILE__ . " script failed.", $ex);
}
