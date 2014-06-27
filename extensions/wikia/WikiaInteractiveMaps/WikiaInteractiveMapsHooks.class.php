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

		// add the asset only on Special:Maps page
		if( self::isSpecialMapsPage() ) {
			$scripts = AssetsManager::getInstance()->getURL( 'int_map_special_page_js' );

			foreach( $scripts as $script ) {
				$text .= Html::linkedScript( $script );
			}
		}

		return true;
	}

	/**
	 * @brief Adds the CSS asset
	 *
	 * @param OutputPage $out
	 * @param string $text article HTML
	 *
	 * @return bool: true because it is a hook
	 */
	static public function onOutputPageBeforeHTML( OutputPage $out, &$text ) {
		global $wgEnableWikiaInteractiveMaps;

		if( !empty( $wgEnableWikiaInteractiveMaps ) && $out->isArticle() ) {
			F::app()->wg->Out->addStyle( AssetsManager::getInstance()->getSassCommonURL( 'extensions/wikia/WikiaInteractiveMaps/css/intMapParserTag.scss' ) );
		}

		return true;
	}

	/**
	 * @brief Returns true if interactive maps are enabled and the current page is Special:Maps
	 *
	 * @return bool
	 */
	private static function isSpecialMapsPage() {
		global $wgEnableWikiaInteractiveMaps, $wgTitle;

		return !empty( $wgEnableWikiaInteractiveMaps )
			&& $wgTitle->isSpecial( WikiaInteractiveMapsController::PAGE_NAME );
	}

}

