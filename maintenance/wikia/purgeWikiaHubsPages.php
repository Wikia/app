<?php
/**
 * Purge WikiaHubs pages every day
 *
 * Usage: SERVER_ID=80433 php purgeWikiaHubsPages.php --conf=/usr/wikia/docroot/wiki.factory/LocalSettings.php
 *
 * @addto maintenance
 * @author Maciej Brencz (Macbre) <macbre at wikia-inc.com>
 * @see https://internal.wikia-inc.com/wiki/Hubs
 */

ini_set("include_path", dirname(__FILE__) . "/..");
require_once('commandLine.inc');

echo "Purging WikiaHubs pages...\n\n";

foreach ($wgWikiaHubsPages as $hubGroup) {
	foreach ($hubGroup as $hubName) {
		echo "* {$hubName}... ";

		$res = false;
		$title = Title::newFromText($hubName);

		if ($title instanceof Title) {
			$article = Article::newFromID($title->getArticleID());

			if ($article instanceof Article) {
				// purge parser cache and varnish
				$article->doPurge();

				$url = $title->getFullURL();
				echo "ok <{$url}>\n";

				$res = true;
			}
		}

		if ($res === false) {
			echo "failed!\n";
		}
	}
}