<?php

class FeedsAndPostsHooks {

	const WIKI_IDS = [
		147, // Star Wars/Wookiepedia
		509, // harry Potter
		1706, // The Elder Scrolls
		1619010, // xkxd (for testing purposes)
	];

	/**
	 * Checks whether the JS assets should be loaded for Feeds and Posts integration
	 *
	 * @return bool
	 */
	private static function shouldLoadAssets() {
		global $wgCityId;

		return in_array( $wgCityId, self::WIKI_IDS ) && WikiaPageType::isArticlePage();
	}

	/**
	 * Add to Javascript assets on Oasis
	 *
	 * @param array $jsAssets
	 *
	 * @return bool
	 */
	public static function onOasisSkinAssetGroups( &$jsAssets ) {
		global $wgNoExternals;

		if ( self::shouldLoadAssets() ) {
			$jsAssets[] = 'feeds_and_posts_js';
		}

		return true;
	}
}
