<?php

class PortableInfoboxHooks {
	// TODO: Add to global css group on sitewide release
	static public function onBeforePageDisplay( OutputPage $out, Skin $skin ) {
		Wikia::addAssetsToOutput( 'portable_infobox_scss' );
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
		$scripts = AssetsManager::getInstance()->getURL( 'portable_infobox_js' );

		foreach ( $scripts as $script ) {
			$text .= Html::linkedScript( $script );
		}

		return true;
	}
}
