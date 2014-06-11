<?php
class WikiaInteractiveMapsHooks {

	/**
	 * @brief Adds the JS asset to the bottom scripts
	 *
	 * @param $skin
	 * @param String $text
	 *
	 * @return bool
	 */
	public static function onSkinAfterBottomScripts( $skin, &$text ) {
		global $wgEnableWikiaInteractiveMaps, $wgExtensionsPath;

		if( !empty( $wgEnableWikiaInteractiveMaps ) ) {
			// add the asset to every page
			$text .= Html::linkedScript( $wgExtensionsPath . '/wikia/WikiaInteractiveMaps/js/WikiaInteractiveMapsParserTag.js' );
		}

		if( self::isSpecialInteractiveMapsPage() ) {
			// add the asset only on Special:InteractiveMaps page
			$text .= Html::linkedScript( $wgExtensionsPath . '/wikia/WikiaInteractiveMaps/js/WikiaInteractiveMaps.js' );
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

}
