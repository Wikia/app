<?php

class WikiFactoryOnVarChange {

	static public function dispatch($name, $city_id, $value) {
#trigger_error("WikiFactoryOnVarChange: (1)");

		$listeners = array(
			"wgEnableNewsiteExt" => array("SetupTablesForWebsitewiki"),
		);

		if (!empty($listeners[$name])) {
			foreach ($listeners[$name] as $listener) {
#trigger_error("WikiFactoryOnVarChange: (2) " . print_r(array($listener, $name, $city_id, $value), true));
				call_user_func(array("WikiFactoryOnVarChange", $listener), $name, $city_id, $value);
			}
		}

		return true;
	}

	static public function SetupTablesForWebsitewiki($name, $city_id, $value) {
#trigger_error("WikiFactoryOnVarChange: (3) " . print_r(array(__METHOD__, $name, $city_id, $value), true));

		global $IP;
		$dbname = WikiFactory::IDtoDB($city_id);

		# liberal amout of c&p from AutoCreateWikiPage::createWiki
		# TODO: refactor

		$dbw_local = wfGetDB( DB_MASTER, array(), $dbname );

		$sqlfiles = array(
			"{$IP}/extensions/3rdparty/Websitewiki/keywords.sql",
			"{$IP}/extensions/3rdparty/Websitewiki/ratings.sql",
			"{$IP}/extensions/wikia/newsite/related.sql",
		);

		foreach ($sqlfiles as $file) {
			$error = $dbw_local->sourceFile( $file );
		}

		$dbw_local->commit();

		return true;
	}
}
