<?php

class NeueWebsiteWF {

	static public function onChange($name, $city_id, $value) {
		if ("wgMakeWikiWebsite" != $name) return true;

		global $IP;
		$dbname = WikiFactory::IDtoDB($city_id);

		# liberal amout of c&p from AutoCreateWikiPage::createWiki
		# TODO: refactor

		$dbw_local = wfGetDB( DB_MASTER, array(), $dbname );

		$sqlfiles = array(
			"{$IP}/extensions/3rdparty/Websitewiki/keywords.sql",
			"{$IP}/extensions/3rdparty/Websitewiki/ratings.sql",
		);

		foreach ($sqlfiles as $file) {
			$error = $dbw_local->sourceFile( $file );
		}

		$dbw_local->commit();

		return true;
	}
}
