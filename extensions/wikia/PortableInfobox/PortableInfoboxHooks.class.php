<?php

class PortableInfoboxHooks {
	// FIX ME: temporary implementation - styles should be included only on page with portable infobox
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

	/**
	 * Add aside HTML tag to accepted list
	 * @param $includeTags parser accepted tags list
	 * @param $excludeTags parser excluded tags list
	 * @return bool
	 */
	public static function onSanitizerTagsLists( &$includeTags, &$excludeTags ) {
		$includeTags[ ] = 'aside';
		return true;
	}

	/**
	 * Ass aside attributes to whitelist
	 * @param $whitelist
	 * @return bool
	 */
	public static function onSanitizerAttributesSetup( &$whitelist ) {
		if ( !isset( $whitelist[ 'aside' ] ) ) {
			$whitelist[ 'aside' ] = [ 'id', 'class', 'lang', 'dir', 'title', 'style' ];
		}
		return true;
	}
}
