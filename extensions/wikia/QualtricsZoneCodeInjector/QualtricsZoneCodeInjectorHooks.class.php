<?php

class QualtricsZoneCodeInjectorHooks {
	const ZONE_CODE = 'ZN_eKkIzldP6dOXaXr'; // This is test zone code - it should be changed before merging to dev
	const SAMPLING = 5; // in percent

	/**
	 * Add important Qualtrics-related variables to javascript
	 *
	 * @param $vars
	 *
	 * @return bool
	 */
	static public function onResourceLoaderGetConfigVars( &$vars ) {
		if ( $vars['skin'] == 'oasis' ) {
			$vars['wgQualtricsZoneCode']     = self::ZONE_CODE;
			$vars['wgQualtricsZoneSampling'] = self::SAMPLING;
			$vars['wgQualtricsZoneUrl']      = self::BuildQualtricsUri();
		}

		return true;
	}

	/**
	 * Adding markup for Qualtrics and setting up SkinAfterBottomScripts hook
	 *
	 * @param $skin
	 * @param $html
	 *
	 * @return bool
	 */
	static public function onGetHTMLAfterBody( $skin, &$html ) {
		if ( $skin->skinname == 'oasis' ) {
			global $wgHooks;

			$html .= '<!-- START OF QUALTRICS INJECTION -->'
				. '<div id="' . self::ZONE_CODE . '"></div>'
				. '<!-- END OF QUALTRICS INJECTION -->';

			$wgHooks['SkinAfterBottomScripts'][] = 'QualtricsZoneCodeInjectorHooks::onSkinAfterBottomScripts';
		}

		return true;
	}

	/**
	 * Add javascript on bottom of the page.
	 *
	 * @param $skin
	 * @param $bottomScripts
	 *
	 * @return bool
	 */
	static public function onSkinAfterBottomScripts( $skin, &$bottomScripts ) {
		global $wgExtensionsPath;

		$src = $wgExtensionsPath . '/wikia/QualtricsZoneCodeInjector/js/QualtricsZoneCodeInjector.js';
		$bottomScripts .= '<script async src="' . $src . '"></script>';

		return true;
	}

	/**
	 * Construct URI for Qualtrics
	 *
	 * @return string
	 */
	static private function BuildQualtricsUri() {
		return '//' . strtolower( self::ZONE_CODE ) . '-wikia.siteintercept.qualtrics.com/WRSiteInterceptEngine/'
		. '?Q_ZID=' . self::ZONE_CODE . '&Q_LOC=' . self::encodeURIComponent( $_SERVER['SCRIPT_URI'] );
	}

	/**
	 * Javascript's encodeURIComponent function
	 *
	 * @param $str URI to encode
	 *
	 * @return string
	 */
	static private function encodeURIComponent( $str ) {
		return strtr( rawurlencode( $str ), [ '%21' => '!', '%2A' => '*', '%27' => "'", '%28' => '(', '%29' => ')' ] );
	}
}
