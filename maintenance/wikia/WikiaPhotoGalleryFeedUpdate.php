<?php
/**
 * WikiaPhotoGalleryFeedUpdate
 *
 * @package MediaWiki
 * @subpackage Maintanance
 *
 * @author: Marooned <marooned at wikia-inc.com>
 *
 */

require_once('../commandLine.inc');

if (isset($options['help'])) {
	die( "Usage: php WikiaPhotoGalleryFeedUpdate.php [--quiet]

		  --help     you are reading it right now
		  --quiet    do not print anything to output\n\n");
}

global $wgExternalDatawareDB;

$timestemp = wfTimestamp(TS_DB, time()-24*60*60 /*24h*/);
$dbr = wfGetDB(DB_SLAVE, array(), $wgExternalDatawareDB);

$oRes = $dbr->select(
	'photo_gallery_feeds',
	array('url'),
	array("timestamp < '$timestemp'"),
	__METHOD__
);

$count = 0;
while ($oRow = $dbr->fetchObject($oRes)) {
	if (!isset($options['quiet'])) {
		echo "Updating feed: {$oRow->url}\n";
	}
	$images = WikiaPhotoGalleryRSS::parseFeed($oRow->url, true);
	$count++;
}

if (!isset($options['quiet'])) {
	echo "Updated $count feeds.\n";
}