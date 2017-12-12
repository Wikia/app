<?php

class ArticleVideoHooks {
	public static function onBeforePageDisplay( \OutputPage $out/*, \Skin $skin*/ ) {
		$pageId = $out->getTitle()->getArticleID();

		$featuredVideoData = ArticleVideoContext::getFeaturedVideoData( $pageId );

		if ( !empty( $featuredVideoData ) ) {
			self::addJWPlayerAssets( $out, $featuredVideoData );
		}

		return true;
	}

	private static function addJWPlayerAssets() {
		\Wikia::addAssetsToOutput( 'jwplayer_scss' );
		\Wikia::addAssetsToOutput( 'jwplayer_js' );
	}

	public static function onInstantGlobalsGetVariables( array &$vars ): bool {
		$vars[] = 'wgArticleVideoAutoplayCountries';
		$vars[] = 'wgArticleVideoNextVideoAutoplayCountries';

		return true;
	}
}
