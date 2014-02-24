<?php

/**
 * Class LightboxHooks
 */
class LightboxHooks {

	/**
	 * @param array $vars
	 * @return bool
	 */
	public static function onMakeGlobalVariablesScript( &$vars ) {
		global $wgShowAdModalInterstitialTimes;

		// How many ads to show while browsing Lightbox
		if ( !$wgShowAdModalInterstitialTimes ) {
			$wgShowAdModalInterstitialTimes = 1; // default: 1
		}

		$vars['wgEnableLightboxExt'] = true;
		$vars['wgShowAdModalInterstitialTimes'] = $wgShowAdModalInterstitialTimes;

		return true;
	}

}
