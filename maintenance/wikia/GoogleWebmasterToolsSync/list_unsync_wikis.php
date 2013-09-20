<?php

// example: SERVER_ID=5915 php maintenance/wikia/GoogleWebmasterToolsSync/list_unsync_wikis.php --conf /usr/wikia/docroot/wiki.factory/LocalSettings.php

require_once( __DIR__."/common.php" );
GWTLogHelper::notice( __FILE__ . " script starts.");
try {
	$wikiRepository = new GWTWikiRepository();
	$wikis = $wikiRepository->allUnassigned();

	foreach ( $wikis as $i => $w ) {
		echo $w->getWikiId() . " " . $w->getDb() . " page count = " . $w->getPageCount() . "\n";
	}

} catch ( Exception $ex ) {
	GWTLogHelper::error( __FILE__ . " script failed.", $ex);
}
