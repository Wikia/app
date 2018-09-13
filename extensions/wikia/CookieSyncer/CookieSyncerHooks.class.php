<?php

class CookieSyncerHooks {
	public static function onBeforePageDisplay() {
		\Wikia::addAssetsToOutput( 'cookiesyncer_js' );

		return true;
	}

	/**
	 * @param array $vars JS variables to be added at the bottom of the page
	 * @param $scripts
	 */
	public static function addCookieSyncerJsVariable( array &$vars, &$scripts ) {
		global $wgCookieSyncerApiUrl;
		$vars['wgCookieSyncerApiUrl'] = $wgCookieSyncerApiUrl;
	}
}
