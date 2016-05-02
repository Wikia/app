<?php

class ARecoveryEngineHooks {

	/**
	 * Register recovery related scripts on the top
	 *
	 * @param array $vars
	 * @param array $scripts
	 *
	 * @return bool
	 */
	public static function onWikiaSkinTopScripts( &$vars, &$scripts ) {
		global $wgEnableUsingSourcePointProxyForCSS;

		if ( empty( $wgEnableUsingSourcePointProxyForCSS ) ) {
			return true;
		}
		$scripts .= F::app()->sendRequest( 'ARecoveryEngineApiController', 'getBootstrap' );
		return true;
	}

	public static function onBeforePageDisplay(&$outputPage, &$skin) {
		global $wgOasisLastCssScripts;
		$sp = new ARecoveryUnlockCSS($outputPage);
		$wgOasisLastCssScripts[] = $sp->getUnlockCSSUrl();
		return true;
	}
}
