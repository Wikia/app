<?php
class WikiaMapsHooks {

	/**
	 * Adds Wikia Maps assets
	 *
	 * @param array $assetsArray
	 *
	 * @return bool
	 */
	public static function onOasisSkinAssetGroups( Array &$assetsArray ) {
		$assetsArray[] = 'wikia_maps_contribution_button_create_map_js';
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
			$scripts = AssetsManager::getInstance()->getURL( 'wikia_maps_special_page_js' );

			foreach ( $scripts as $script ) {
				$text .= Html::linkedScript( $script );
			}
		}
		return true;
	}

	/**
	 * @brief Returns true if Wikia Maps are enabled and the current page is Special:Maps
	 *
	 * @return bool
	 */
	private static function isSpecialMapsPage() {
		global $wgEnableWikiaInteractiveMaps, $wgTitle;

		return !empty( $wgEnableWikiaInteractiveMaps )
			&& $wgTitle->isSpecial( WikiaMapsSpecialController::PAGE_NAME );
	}

	/**
	 * @brief Returns true if the current page is Special:Maps single map page
	 *
	 * @return bool
	 */
	public static function isSingleMapPage() {
		global $wgTitle;

		$find = [
			WikiaMapsSpecialController::PAGE_NAME . '/',
			WikiaMapsSpecialController::PAGE_NAME
		];
		$titleFiltered = (int) str_replace( $find, '', $wgTitle->getSubpageText() );

		return $titleFiltered > 0;
	}

	/**
	 * @brief WikiaMobile hook to add assets so they are minified and concatenated
	 *
	 * @param array $jsStaticPackages
	 * @param array $jsExtensionPackages
	 * @param array $scssPackages
	 *
	 * @return Boolean
	 */
	public static function onWikiaMobileAssetsPackages( &$jsStaticPackages, &$jsExtensionPackages, &$scssPackages ) {
		if ( self::isSpecialMapsPage() ) {
			$scssPackages[] = 'wikia_maps_special_page_scss_wikiamobile';
			$jsExtensionPackages[] = 'wikia_maps_special_page_js_wikiamobile';
		} else {
			$scssPackages[] = 'wikia_maps_parser_tag_scss_wikiamobile';
			$jsExtensionPackages[] = 'wikia_maps_parser_tag_js_wikiamobile';
		}
		return true;
	}

	/**
	 * @brief Adds fragment metatag in <head> section on single maps' pages
	 * 
	 * @param OutputPage $out
	 * 
	 * @return bool true
	 */
	public static function onBeforePageDisplay( $out ) {
		if ( self::isSpecialMapsPage() && self::isSingleMapPage() ) {
			$out->addMeta( 'fragment', '!' );
		}
		return true;
	}
}
