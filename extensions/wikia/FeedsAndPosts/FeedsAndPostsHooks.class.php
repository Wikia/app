<?php

class FeedsAndPostsHooks {

	/**
	 * Checks whether the JS assets should be loaded for Feeds and Posts integration
	 *
	 * @return bool
	 */
	private static function shouldLoadAssets() {
		return WikiaPageType::isArticlePage();
	}

	/**
	 * Add to Javascript assets on Oasis
	 *
	 * @param array $jsAssets
	 *
	 * @return bool
	 */
	public static function onOasisSkinAssetGroups( &$jsAssets ) {
		if ( self::shouldLoadAssets() ) {
			$jsAssets[] = 'feeds_and_posts_js';
		}

		return true;
	}
}
