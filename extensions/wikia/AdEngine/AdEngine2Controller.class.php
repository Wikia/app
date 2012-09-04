<?php

/**
 * AdEngine II Controller
 */
class AdEngine2Controller extends WikiaController {

	/**
	 * register ad-related vars on top
	 *
	 * @param $vars
	 * @return bool
	 */
	public function onWikiaSkinTopScripts(&$vars) {
		wfProfileIn(__METHOD__);

		$vars['adslots2'] = array();

		wfProfileOut(__METHOD__);

		return true;
	}
}