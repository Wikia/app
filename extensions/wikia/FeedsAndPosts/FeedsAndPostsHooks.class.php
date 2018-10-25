<?php

class FeedsAndPostsHooks {

	/**
	 * Checks whether the JS assets should be loaded for Feeds and Posts integration
	 *
	 * @return bool
	 */
	private static function shouldShowEmbeddedFeed() {
		global $wgEnableFeedsAndPostsEmbeddedFeed;

		return $wgEnableFeedsAndPostsEmbeddedFeed && WikiaPageType::isArticlePage();
	}

	public static function onBeforePageDisplay() {
		if ( self::shouldShowEmbeddedFeed() ) {
			\Wikia::addAssetsToOutput( 'feeds_and_posts_scss' );
			\Wikia::addAssetsToOutput( 'feeds_and_posts_js' );
		}

		return true;
	}

	public static function onMakeGlobalVariablesScript( array &$vars ) {
		if ( self::shouldShowEmbeddedFeed() ) {
			$vars['showEmbeddedFeed'] = true;
		}
		return true;
	}
}
