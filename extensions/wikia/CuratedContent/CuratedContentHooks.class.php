<?php
class CuratedContentHooks {
	/**
	 * @brief Whenever data is saved in Curated Content Management Tool
	 * purge Varnish cache for it and Game Guides
	 *
	 * @return bool
	 */
	static function onCuratedContentSave() {
		global $wgServer, $wgWikiaCuratedContent;

		( new SquidUpdate( array_unique( array_reduce(
			$wgWikiaCuratedContent,
			function ( $urls, $item ) use ( $wgServer ) {
				if ( $item['title'] !== '' && empty( $item['featured'] ) ) {
					// Purge section URLs using urlencode() (standard for MediaWiki), which uses implements RFC 1738
					// https://tools.ietf.org/html/rfc1738#section-2.2 - spaces encoded as `+`.
					// iOS apps use this variant.
					$urls[] = self::getUrl( 'getList' ) . '&section=' . urlencode( $item['title'] );
					// Purge section URLs using rawurlencode(), which uses implements RFC 3986
					// https://tools.ietf.org/html/rfc3986#section-2.1 - spaces encoded as `%20`.
					// Android apps use this variant.
					$urls[] = self::getUrl( 'getList' ) . '&section=' . rawurlencode( $item['title'] );
				}

				return $urls;
			} ,
			// Purge all sections list getter URL - no additional params
			[ self::getUrl( 'getList' ), self::getUrl( 'getData' ) ]
		) ) ) )->doUpdate();

		// Purge cache for obsolete (not updated) apps.
		if ( class_exists( 'GameGuidesController' ) ) {
			GameGuidesController::purgeMethod( 'getList' );
		}

		return true;
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
		if ( self::shouldDisplayCuratedContentToolButton() ) {
			$scripts = AssetsManager::getInstance()->getURL( 'curated_content_tool_button_js' );

			foreach ( $scripts as $script ) {
				$text .= Html::linkedScript( $script );
			}
		}
		return true;
	}

	private static function shouldDisplayCuratedContentToolButton() {
		global $wgEnableCuratedContentExt, $wgUser;

		return WikiaPageType::isMainPage() &&
		!empty( $wgEnableCuratedContentExt ) &&
		$wgUser->isAllowed( 'curatedcontent' );
	}
}
