<?php

class ArticleVideoHooks {
	public static function onBeforePageDisplay( \OutputPage $out/*, \Skin $skin*/ ) {
		$articleId = $out->getTitle()->getArticleID();

		if ( ArticleVideoContext::isFeaturedVideoEmbedded( $articleId ) ) {
			self::addFeaturedVideoAssets();
		} else if ( ArticleVideoContext::isRecommendedVideoAvailable( $articleId ) ) {
			self::addRecommendedVideoAssets();
		}

		return true;
	}

	private static function addFeaturedVideoAssets() {
		\Wikia::addAssetsToOutput( 'jwplayer_scss' );
		\Wikia::addAssetsToOutput( 'jwplayer_js' );
	}

	private static function addRecommendedVideoAssets() {
		\Wikia::addAssetsToOutput( 'recommended_video_css' );
		\Wikia::addAssetsToOutput( 'recommended_video_scss' );
		\Wikia::addAssetsToOutput( 'recommended_video_js' );
	}

	public static function onInstantGlobalsGetVariables( array &$vars ): bool {
		$vars[] = 'wgArticleVideoAutoplayCountries';
		$vars[] = 'wgArticleVideoNextVideoAutoplayCountries';

		return true;
	}
}
