<?php
/**
 * User: artur
 * Date: 17.04.13
 * Time: 19:15
 */

// example: SERVER_ID=5915 php maintenance/wikia/GoogleWebmasterToolsSync/list_unsync_wikis.php --conf /usr/wikia/docroot/wiki.factory/LocalSettings.php

require_once(__DIR__ . '/../../commandLine.inc');
require_once($IP . '/lib/GoogleWebmasterTools/setup.php');

$wikiRepository = new GWTWikiRepository();
$wikis = $wikiRepository->allUnassigned();

foreach ( $wikis as $i => $w ) {
	echo $w->getWikiId() . " " . $w->getDb() . "\n";
}
