<?php

class ArticleVideoHooks {
	public static function onBeforePageDisplay( \OutputPage $out, \Skin $skin ) {
		$wg = F::app()->wg;
		$title = $wg->Title->getPrefixedDBkey();

		$isFeaturedVideoEmbedded = ArticleVideoContext::isFeaturedVideoEmbedded( $title );
		$isRelatedVideoEmbedded = ArticleVideoContext::isRelatedVideoEmbedded( $title );

		if ( $isFeaturedVideoEmbedded || $isRelatedVideoEmbedded ) {
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

	public static function onMakeGlobalVariablesScript( array &$vars, OutputPage $out ) {
		$wg = F::app()->wg;
		$title = $wg->Title->getPrefixedDBkey();

		if ( ArticleVideoContext::isFeaturedVideoEmbedded( $title ) ) {
			$vars['wgOoyalaParams'] = [
				'ooyalaPCode' => $wg->ooyalaApiConfig['pcode'],
				'ooyalaPlayerBrandingId' => $wg->ooyalaApiConfig['playerBrandingId'],
			];
			$vars['wgFeaturedVideoId'] = $wg->articleVideoFeaturedVideos[$title]['videoId'];
		}

		$relatedVideo = ArticleVideoContext::getRelatedVideoData( $title );
		if ( !empty( $relatedVideo ) ) {
			$vars['wgOoyalaParams'] = [
				'ooyalaPCode' => $wg->ooyalaApiConfig['pcode'],
				'ooyalaPlayerBrandingId' => $wg->ooyalaApiConfig['playerBrandingId'],
			];
			$vars['wgRelatedVideoId'] = $relatedVideo['videoId'];
		}

		return true;
	}
}
