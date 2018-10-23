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

	public static function onBeforePageDisplay() {
		if ( self::shouldLoadAssets() ) {
			\Wikia::addAssetsToOutput( 'feeds_and_posts_scss' );
			\Wikia::addAssetsToOutput( 'feeds_and_posts_js' );
		}

		return true;
	}

	public static function onMakeGlobalVariablesScript( array &$vars ) {
		if ( self::shouldLoadAssets() ) {
			$vars['canLoadFeedsAndPosts'] = true;
		}
		return true;
	}
}
