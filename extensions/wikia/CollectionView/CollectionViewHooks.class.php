<?php
class CollectionViewHooks {
	// FIX ME: temporary implementation - styles should be included only on page with collection view
//	static public function onBeforePageDisplay( OutputPage $out, Skin $skin ) {
//		Wikia::addAssetsToOutput('collection_view_scss');
//		return true;
//	}

	/**
	 * Adds assets on the bottom of the body tag
	 *
	 * @param {String} $skin
	 * @param {String} $text
	 *
	 * @return bool
	 */
	public static function onSkinAfterBottomScripts( $skin, &$text ) {
		$scripts = AssetsManager::getInstance()->getURL( 'collection_view_js' );

		foreach ( $scripts as $script ) {
			$text .= Html::linkedScript( $script );
		}

		return true;
	}
}
