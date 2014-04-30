<?php
class WikiaInteractiveMapsHooks {

	/**
	 * @desc Adds the JS asset to the bottom scripts
	 *
	 * @param $skin
	 * @param String $text
	 *
	 * @return bool
	 */
	public static function onSkinAfterBottomScripts( $skin, &$text ) {
		global $wgEnableWikiaInteractiveMaps;

		if( !empty( $wgEnableWikiaInteractiveMaps ) ) {
			// add the asset to every page
			$text .= self::buildScriptTag( 'wikia/WikiaInteractiveMaps/js/WikiaInteractiveMapsPraserTag.js' );
		}

		if( self::isSpecialInteractiveMapsPage() ) {
			// add the asset only on Special:InteractiveMaps page
			$text .= self::buildScriptTag( 'wikia/WikiaInteractiveMaps/js/WikiaInteractiveMaps.js' );
		}

		return true;
	}

	/**
	 * @brief Returns true if interactive maps are enabled and the current page is Special:InteractiveMaps
	 *
	 * @return bool
	 */
	private static function isSpecialInteractiveMapsPage() {
		global $wgEnableWikiaInteractiveMaps, $wgTitle;

		return !empty( $wgEnableWikiaInteractiveMaps ) && $wgTitle->isSpecial( 'InteractiveMaps' );
	}

	/**
	 * @brief Returns string with <script></script> tag for given JS asset
	 *
	 * @param $scriptPath
	 *
	 * @return string
	 */
	private static function buildScriptTag( $scriptPath ) {
		global $wgExtensionsPath;

		return sprintf(
			'<script src="%s/%s"></script>',
			$wgExtensionsPath,
			$scriptPath
		);
	}

}
