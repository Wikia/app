<?php

class CuratedContentHooks {
	/**
	 * @brief Whenever data is saved in Curated Content Management Tool
	 * purge Varnish cache for it and Game Guides
	 *
	 * @return bool
	 */
	static function onCuratedContentSave() {
		global $wgCityId;

		$curated = ( new CommunityDataService( $wgCityId ) )->getCurated();
		( new SquidUpdate( self::createCuratedContentUrlsPurgeList( $curated ) ) )->doUpdate();

		// Purge cache for obsolete (not updated) apps.
		if ( class_exists( 'GameGuidesController' ) ) {
			GameGuidesController::purgeMethod( 'getList' );
		}

		return true;
	}

	public static function createCuratedContentUrlsPurgeList( $curated ) {
		return array_unique( array_reduce( $curated,
			function ( $urls, $item ) {
				// Purge section URLs using urlencode() (standard for MediaWiki), which uses implements RFC 1738
				// https://tools.ietf.org/html/rfc1738#section-2.2 - spaces encoded as `+`.
				// iOS apps use this variant.
				$urls[] = CuratedContentController::getUrl( 'getList' ) . '&section=' . urlencode( $item[ 'label' ] );
				// Purge section URLs using rawurlencode(), which uses implements RFC 3986
				// https://tools.ietf.org/html/rfc3986#section-2.1 - spaces encoded as `%20`.
				// Android apps use this variant.
				$urls[] = CuratedContentController::getUrl( 'getList' ) . '&section=' . rawurlencode( $item[ 'label' ] );
				return $urls;
			},
			// Purge all sections list getter URL - no additional params
			[ CuratedContentController::getUrl( 'getList' ), CuratedContentController::getUrl( 'getData' ) ]
		) );
	}

	/**
	 * Adds assets on the bottom of the body tag
	 *
	 * @param {String} $skin
	 * @param {String} $text
	 *
	 * @return bool
	 */
	public static function onSkinAfterBottomScripts( $skin, &$text ) {
		if ( CuratedContentHelper::shouldDisplayToolButton() ) {
			$assetsManager = AssetsManager::getInstance();
			$scripts = $assetsManager->getURL( 'curated_content_tool_button_js' );

			foreach ( $scripts as $script ) {
				$text .= Html::linkedScript( $script );
			}

			$styles = $assetsManager->getSassGroupCommonURL( 'curated_content_tool_button_scss' );

			foreach ( $styles as $style ) {
				$text .= Html::linkedStyle( $style );
			}
		}
		return true;
	}

	public static function onOutputPageBeforeHTML() {
		if ( CuratedContentHelper::shouldDisplayToolButton() ) {
			JSMessages::enqueuePackage( 'CuratedContentModal', JSMessages::INLINE );
		}
		return true;
	}
}
