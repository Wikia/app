<?php

class ArticleVideoHooks {
	public static function onBeforePageDisplay( \OutputPage $out, \Skin $skin ) {
		$wg = F::app()->wg;
		$title = $wg->Title->getPrefixedDBkey();

		$isFeaturedVideoEmbedded = ArticleVideoContext::isFeaturedVideoEmbedded( $title );
		$isRelatedVideoEmbedded = ArticleVideoContext::isRelatedVideoEmbedded( $title );

		if ( $isFeaturedVideoEmbedded || $isRelatedVideoEmbedded ) {
			// Bitmovin plugin loads additional files which have to be accessible on the same path as plugin
			// AssetsManager produces a custom path based on the group name, so we can't use it here
			$out->addScriptFile(
				'/extensions/wikia/ArticleVideo/bower_components/html5-skin/build/all-with-bitmovin.js'
			);

			$out->addScriptFile(
				'/extensions/wikia/ArticleVideo/scripts/ooyala/google_ima.js'
			);

			// html5-skin has hardcoded, relative path to fonts so we can't use the AssetsManager
			$out->addExtensionStyle(
				'/extensions/wikia/ArticleVideo/bower_components/html5-skin/build/html5-skin.css'
			);

			\Wikia::addAssetsToOutput( 'ooyala_scss' );
			\Wikia::addAssetsToOutput( 'ooyala_js' );
		}

		if ( $isFeaturedVideoEmbedded ) {
			\Wikia::addAssetsToOutput( 'article_featured_video_scss' );
			\Wikia::addAssetsToOutput( 'article_featured_video_js' );
		}

		if ( $isRelatedVideoEmbedded ) {
			\Wikia::addAssetsToOutput( 'article_related_video_scss' );
			\Wikia::addAssetsToOutput( 'article_related_video_js' );
		}

		return true;
	}

	public static function onMakeGlobalVariablesScript( array &$vars/*, OutputPage $out*/ ) {
		$wg = F::app()->wg;
		$title = $wg->Title->getPrefixedDBkey();

		$featuredVideo = ArticleVideoContext::getFeaturedVideoData( $title );
		$relatedVideo = ArticleVideoContext::getRelatedVideoData( $title );

		if ( !empty( $featuredVideo ) || !empty( $relatedVideo ) ) {
			$vars['wgOoyalaParams'] = [
				'ooyalaPCode' => $wg->ooyalaApiConfig['pcode'],
				'ooyalaPlayerBrandingId' => $wg->ooyalaApiConfig['playerBrandingId'],
			];
		}

		if ( !empty( $featuredVideo ) ) {
			$vars['wgFeaturedVideoId'] = $featuredVideo['videoId'];
			$vars['wgFeaturedVideoLabels'] = $featuredVideo['labels'];
		}

		if ( !empty( $relatedVideo ) ) {
			$vars['wgRelatedVideoId'] = $relatedVideo['videoId'];
		}

		return true;
	}
}
