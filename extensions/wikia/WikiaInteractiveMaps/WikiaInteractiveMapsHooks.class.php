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
		global $wgEnableWikiaInteractiveMaps, $wgExtensionsPath, $wgResourceBasePath;

		if( !empty( $wgEnableWikiaInteractiveMaps ) ) {
			// add the asset to every page
			$text .= Html::linkedScript( $wgExtensionsPath . '/wikia/WikiaInteractiveMaps/js/WikiaInteractiveMapsParserTag.js' );
		}

		// add the asset only on Special:InteractiveMaps page
		if( self::isSpecialInteractiveMapsPage() ) {
			$scripts = AssetsManager::getInstance()->getURL( 'int_map_special_page_js' );

			foreach( $scripts as $script ) {
				$text .= Html::linkedScript( $script );
			}
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
