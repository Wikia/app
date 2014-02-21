<?php

class QualtricsZoneCodeInjectorHooks {
	/**
	 * Add important Qualtrics-related variables to javascript
	 *
	 * @param $vars
	 *
	 * @return bool
	 */
	static public function onResourceLoaderGetConfigVars( &$vars ) {
		if ( $vars['skin'] == 'oasis' ) {
			global $wgQualtricsZoneSampling;

			$vars['wgQualtricsZoneSampling'] = $wgQualtricsZoneSampling;
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
			global $wgQualtricsZoneCode;

			$html .= '<!-- START OF QUALTRICS INJECTION -->'
				. '<div id="' . $wgQualtricsZoneCode . '"></div>'
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
		global $wgQualtricsZoneCode;

		return '//' . strtolower( $wgQualtricsZoneCode ) . '-wikia.siteintercept.qualtrics.com/WRSiteInterceptEngine/'
		. '?Q_ZID=' . $wgQualtricsZoneCode . '&Q_LOC=' . self::encodeURIComponent( $_SERVER['SCRIPT_URI'] );
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
