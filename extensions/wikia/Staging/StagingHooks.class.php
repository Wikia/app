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
			$parts = parse_url( $redirect );

			if ( strpos( $parts['host'], '.wikia.com' ) !== false
				&& strpos( $parts['host'], $stagingEnvName . '.wikia.com' ) === false
				&& $parts['host'] !== 'fandom.wikia.com'
			) {
				$parts['host'] = str_replace( '.wikia.com', '.' . $stagingEnvName . '.wikia.com', $parts['host'] );
				$redirect = http_build_url( '', $parts );
			}
		}

		return true;
	}
}
