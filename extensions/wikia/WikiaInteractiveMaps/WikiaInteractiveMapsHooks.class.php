<?php
class WikiaInteractiveMapsHooks {

	/**
	 * Adds interactive maps assets
	 *
	 * @param Array $assetsArray
	 *
	 * @return bool
	 */
	public static function onOasisSkinAssetGroups( &$assetsArray ) {
		$mapsAssets = [ 'int_map_contribution_button_create_map_js' ];

		if( self::isSpecialMapsPage() ) {
			array_unshift( $mapsAssets, 'int_map_parser_tag_js' );
		}

		$assetsArray = array_merge( $assetsArray, $mapsAssets );

		return true;
	}

	/**
	 * Adds assets on the bottom of the body tag for special maps page
	 *
	 * @param {String} $skin
	 * @param {String} $text
	 *
	 * @return bool
	 */
	public static function onSkinAfterBottomScripts( $skin, &$text ) {
		if ( self::isSpecialMapsPage() ) {
			$scripts = AssetsManager::getInstance()->getURL( 'int_map_special_page_js' );

			foreach ( $scripts as $script ) {
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
	public static function onOutputPageBeforeHTML( OutputPage $out, &$text ) {
		global $wgEnableWikiaInteractiveMaps;

		if ( !empty( $wgEnableWikiaInteractiveMaps ) && $out->isArticle() ) {
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

	/**
	 * @brief WikiaMobile hook to add assets so they are minified and concatenated
	 *
	 * @param Array $jsStaticPackages
	 * @param Array $jsExtensionPackages
	 * @param Array $scssPackages
	 *
	 * @return Boolean
	 */
	public static function onWikiaMobileAssetsPackages( &$jsStaticPackages, &$jsExtensionPackages, &$scssPackages ) {
		if ( self::isSpecialMapsPage() ) {
			$scssPackages[] = 'int_map_special_page_scss_wikiamobile';
			$jsExtensionPackages[] = 'int_map_special_page_js_wikiamobile';
		} else {
			$scssPackages[] = 'int_map_parser_tag_scss_wikiamobile';
			$jsExtensionPackages[] = 'int_map_parser_tag_js_wikiamobile';
		}
		return true;
	}

}
