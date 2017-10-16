<?php

class StagingHooks {
	/**
	* Register global JS variables bottom
	*
	* @param array $vars
	*
	* @return bool
	*/
	static public function onMakeGlobalVariablesScript( &$vars ) {
		Wikia::addAssetsToOutput( 'extensions/wikia/Staging/js/Staging.js' );
		$vars['wgStagingEnvironment'] = true;

		return true;
	}

	/**
	 * Rewrite redirects to preserve staging params
	 *
	 * @param $out
	 * @param $redirect
	 * @param $code
	 * @return bool
	 */
	static public function onBeforePageRedirect( $out, &$redirect, &$code ) {
		if ( !empty( $_SERVER['HTTP_X_STAGING'] ) ) {
			$stagingEnvName = $_SERVER['HTTP_X_STAGING'];
			$stagingUrlPart = '://' . $stagingEnvName . '.';

			if ( strpos( $redirect, 'wikia.com' ) !== false && strpos( $redirect, $stagingUrlPart ) === false ) {
				$redirect = str_replace( '://', $stagingUrlPart, $redirect );
			}
		}

		return true;
	}
}
