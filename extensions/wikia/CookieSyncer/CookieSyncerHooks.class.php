<?php

class CookieSyncerHooks {
	/**
	 * @param array $vars JS variables to be added at the bottom of the page
	 * @param $scripts
	 */
	public static function addCookieSyncerJsVariable( array &$vars, &$scripts ) {
		global $wgCookieSyncerApiUrl;
		$vars['wgCookieSyncerApiUrl'] = $wgCookieSyncerApiUrl;
	}
}
