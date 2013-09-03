<?php

class TouchStormHooks extends WikiaObject {

	/**
	 * Add modules to the right rail if necessary
	 * @param $modules
	 * @return bool
	 */
	static public function onGetRailModuleList(&$modules) {
		$app = F::App();
		wfProfileIn(__METHOD__);

		// These positions are set to be between the Photos module and
		// the Videos module (1303) when logged out and below the Recent Activity module
		// when logged in (1287)
		$pos = $app->wg->User->isAnon() ? 1303 : 1287;
		$modules[$pos] = array('TouchStorm', 'index', null);

		wfProfileOut(__METHOD__);
		return true;
	}
}
