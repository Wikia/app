<?php

class ArticleVideoHooks {
	public static function onBeforePageDisplay( \OutputPage $out/*, \Skin $skin*/ ) {
		$articleId = $out->getTitle()->getArticleID();

		if ( ArticleVideoContext::isFeaturedVideoEmbedded( $articleId ) ) {
			self::addJWPlayerAssets();
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
