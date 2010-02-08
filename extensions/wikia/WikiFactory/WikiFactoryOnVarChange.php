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

		if ($name == "wgEnableNewsiteExt") {
		}

		return true;
	}
}
