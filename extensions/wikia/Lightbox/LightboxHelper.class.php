<?php

/**
 * Lighbox Helper
 * @author Hyun Lim
 * @author Liz Lee
 *
 */
class LightboxHelper extends WikiaModel {

	/**
	 * @param array $vars
	 * @return bool
	 */
	public function onMakeGlobalVariablesScript(Array &$vars) {
		$vars['wgEnableLightboxExt'] = true;
		return true;
	}
}
