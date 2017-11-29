 <?php

class ArticleVideoHooks {
	public static function onBeforePageDisplay( \OutputPage $out/*, \Skin $skin*/ ) {
		$title = RequestContext::getMain()->getTitle()->getPrefixedDBkey();

		$featuredVideoData = ArticleVideoContext::getFeaturedVideoData( $title );

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
