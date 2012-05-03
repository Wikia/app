<?php

/**
 * Lighbox Helper
 * @author Hyun Lim
 * @author Liz Lee
 *
 */
class LightboxHelper extends WikiaModel {
	
	public function onMakeGlobalVariablesScript(&$vars) {
		$vars['wgEnableLightboxExt'] = true;
		return true;
	}
	
}