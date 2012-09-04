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

	/**
	 * register ad-related vars for 1.16
	 *
	 * @param $vars
	 * @return bool
	 */
	public function onMakeGlobalVariableScript(&$vars) {
		wfProfileIn(__METHOD__);

		global $wgVersion;
		if (version_compare( $wgVersion, '1.16.5', '>' )) return true;

		$vars['adslots2'] = array();

		wfProfileOut(__METHOD__);

		return true;
	}
}