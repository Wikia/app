<?php
/**
 * Purge Main Page
 *
 * Usage: SERVER_ID=80433 php purgeWikiaMainPages.php --conf=/usr/wikia/docroot/wiki.factory/LocalSettings.php
 *
 * @addto maintenance
 * @author Sebastian Marzjan
 */

ini_set("include_path", dirname(__FILE__) . "/..");
require_once('commandLine.inc');


echo "\n---------------------\n";
echo date("Y-m-d H:i:s");
echo " / Purging Main page...\n\n";

$msg = wfMsgExt( 'mainpage', array( 'language' => $langCode ) );
$mainpage = $prefix !== null ? $prefix . '/' . $msg : $msg;
$title = Title::newFromText($mainpage);

if ($title instanceof Title) {
	$article = Article::newFromID($title->getArticleID());

	if ($article instanceof Article) {
		// purge parser cache and varnish
		$article->doPurge();
		$url = $title->getFullURL();
		echo "ok <{$url}>\n";
	}
}

echo "\n";
echo date("Y-m-d H:i:s");
echo " / Script finished running!\n\n";
