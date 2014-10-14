<?php

class QualtricsZoneCodeInjectorHooks {
	/**
	 * Add important Qualtrics-related variables to javascript
	 *
	 * @param $vars
	 *
	 * @return bool
	 */
	static public function onMakeGlobalVariablesScript( &$vars, $outputPage ) {
		global $wgNoExternals;

		if ( empty( $wgNoExternals ) && $outputPage->getSkin()->skinname == 'oasis' ) {
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
		global $wgNoExternals;

		if ( empty( $wgNoExternals ) && $skin->skinname == 'oasis' ) {
			global $wgQualtricsZoneCode;

			$html .= '<!-- START OF QUALTRICS INJECTION -->'
				. '<div id="' . $wgQualtricsZoneCode . '"></div>'
				. '<!-- END OF QUALTRICS INJECTION -->';
		}

		return true;
	}

	/**
	 * Add Qualtrics assets on Oasis
	 *
	 * @param $assetsArray
	 *
	 * @return bool
	 */
	static public function onOasisSkinAssetGroups( &$assetsArray ) {
		global $wgNoExternals;

		if ( empty( $wgNoExternals ) ) {
			$assetsArray[] = 'qualtrics_zone_code_injector_js';
		}

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
