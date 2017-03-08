<?php

class ArticleVideoHooks {
	public static function onBeforePageDisplay( \OutputPage $out, \Skin $skin ) {
		$wg = F::app()->wg;
		$title = $wg->Title->getPrefixedDBkey();

		$relatedVideo =
			ArticleVideoController::getRelatedVideoData( $wg->articleVideoRelatedVideos, $title );
		$isFeaturedVideoEmbedded = self::isFeaturedVideoEmbedded( $title );
		$isRelatedVideoEmbedded = self::isRelatedVideoEmbedded( $relatedVideo );

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

		if ( self::isFeaturedVideoEmbedded( $title ) ) {
			$vars['wgOoyalaParams'] = [
				'ooyalaPCode' => $wg->ooyalaApiConfig['pcode'],
				'ooyalaPlayerBrandingId' => $wg->ooyalaApiConfig['playerBrandingId'],
			];
			$vars['wgFeaturedVideoId'] = $wg->articleVideoFeaturedVideos[$title]['videoId'];
		}

		$relatedVideo =
			ArticleVideoController::getRelatedVideoData( $wg->articleVideoRelatedVideos, $title );
		if ( self::isRelatedVideoEmbedded( $relatedVideo ) ) {
			$vars['wgOoyalaParams'] = [
				'ooyalaPCode' => $wg->ooyalaApiConfig['pcode'],
				'ooyalaPlayerBrandingId' => $wg->ooyalaApiConfig['playerBrandingId'],
			];
			$vars['wgRelatedVideoId'] = $relatedVideo['videoId'];
		}

		return true;
	}

	public static function isFeaturedVideoEmbedded( $title ) {
		$wg = F::app()->wg;

		return $wg->enableArticleFeaturedVideo &&
		       isset( $wg->articleVideoFeaturedVideos[$title] ) &&
		       self::isFeaturedVideosValid( $wg->articleVideoFeaturedVideos[$title] );
	}

	public static function isRelatedVideoEmbedded( $relatedVideo ) {
		$wg = F::app()->wg;

		return $wg->enableArticleRelatedVideo && isset( $wg->articleVideoRelatedVideos ) &&
		       !empty( $relatedVideo ) && self::isRelatedVideosValid( $relatedVideo );
	}

	private static function isFeaturedVideosValid( $featuredVideo ) {
		return isset( $featuredVideo['videoId'], $featuredVideo['thumbnailUrl'] );
	}

	private static function isRelatedVideosValid( $relatedVideo ) {
		return isset( $relatedVideo['articles'], $relatedVideo['videoId'] );
	}

}