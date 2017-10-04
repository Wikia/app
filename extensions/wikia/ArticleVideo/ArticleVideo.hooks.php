<?php

class ArticleVideoHooks {
	public static function onBeforePageDisplay( \OutputPage $out/*, \Skin $skin*/ ) {
		$title = RequestContext::getMain()->getTitle()->getPrefixedDBkey();

		$featuredVideoData = ArticleVideoContext::getFeaturedVideoData( $title );
		$relatedVideoData = ArticleVideoContext::getRelatedVideoData( $title );

		if ( !empty( $featuredVideoData ) || !empty( $relatedVideoData ) ) {
			if ( empty( $featuredVideoData ) ||
			     !ArticleVideoContext::isJWPlayer( $featuredVideoData )
			) {
				self::addOoyalaAssets( $out, $featuredVideoData, $relatedVideoData );
			}

			if ( !empty( $featuredVideoData ) &&
			     ArticleVideoContext::isJWPlayer( $featuredVideoData )
			) {
				self::addJWPlayerAssets( $out, $featuredVideoData );
			}
		}

		return true;
	}

	private static function addOoyalaAssets(\OutputPage $out, $featuredVideoData, $relatedVideoData ) {
		$wg = F::app()->wg;
		// Bitmovin plugin loads additional files which have to be accessible on the same path as plugin
		// AssetsManager produces a custom path based on the group name, so we can't use it here
		$out->addScriptFile(
			"{$wg->extensionsPath}/wikia/ArticleVideo/bower_components/html5-skin/build/all-with-bitmovin.js"
		);

		// html5-skin has hardcoded, relative path to fonts so we can't use the AssetsManager
		$out->addExtensionStyle(
			"{$wg->extensionsPath}/wikia/ArticleVideo/bower_components/html5-skin/build/html5-skin.css"
		);

		\Wikia::addAssetsToOutput( 'ooyala_scss' );
		\Wikia::addAssetsToOutput( 'ooyala_js' );

		$out->addJsConfigVars( [
			'wgOoyalaParams' => [
				'ooyalaPCode' => $wg->ooyalaApiConfig['pcode'],
				'ooyalaPlayerBrandingId' => $wg->ooyalaApiConfig['playerBrandingId']
			]
		] );

		if ( !empty( $featuredVideoData ) ) {
			\Wikia::addAssetsToOutput( 'article_featured_video_scss' );
			\Wikia::addAssetsToOutput( 'article_featured_video_js' );

			$out->addJsConfigVars( [
				'wgFeaturedVideoData' => $featuredVideoData
			] );
		}

		if ( !empty( $relatedVideoData ) ) {
			\Wikia::addAssetsToOutput( 'article_related_video_scss' );
			\Wikia::addAssetsToOutput( 'article_related_video_js' );

			$out->addJsConfigVars( [
				'wgRelatedVideoId' => $relatedVideoData['videoId'],
			] );
		}
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
