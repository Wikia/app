<?php

class PageShareHooks {

	/**
	 * Add global JS variable wgAcceptLangList
	 *
	 * @param array $vars global variables list
	 * @return boolean return true
	 */
	public static function onMakeGlobalVariablesScript(Array &$vars) {
		global $wgRequest;

		$wgAcceptLang = $wgRequest->getAcceptLang();
		$vars['wgAcceptLangList'] = is_array( $wgAcceptLang ) ? array_keys( $wgAcceptLang ) : null;

		return true;
	}
}
