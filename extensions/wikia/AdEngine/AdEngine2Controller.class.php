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
		$vars['adslots2'] = array();

		return true;
	}
}