<?php

class ArticleVideoHooks {
	public static function onBeforePageDisplay( \OutputPage $out, \Skin $skin ) {
		$wg = F::app()->wg;
		$title = $wg->Title->getPrefixedDBkey();

		if ( isset( $wg->articleVideoRelatedVideos ) ) {
			$relatedVideo = ArticleVideoController::getRelatedVideoData( $wg->articleVideoRelatedVideos, $title );
		}

		if ( ( $wg->enableArticleFeaturedVideo &&
		       isset( $wg->articleVideoFeaturedVideos[$title] ) ) ||
		     ( $wg->enableArticleRelatedVideo && isset( $relatedVideo ) )
		) {
			\Wikia::addAssetsToOutput( 'ooyala_scss' );
			\Wikia::addAssetsToOutput( 'ooyala_js' );
		}

		if ( $wg->enableArticleFeaturedVideo && isset( $wg->articleVideoFeaturedVideos[$title] ) ) {
			\Wikia::addAssetsToOutput( 'article_featured_video_scss' );
			\Wikia::addAssetsToOutput( 'article_featured_video_js' );
		}
		
		if ( $wg->enableArticleRelatedVideo && isset( $relatedVideo ) ) {
			\Wikia::addAssetsToOutput( 'article_related_video_scss' );
			\Wikia::addAssetsToOutput( 'article_related_video_js' );
		}

		return true;
	}

	public static function onMakeGlobalVariablesScript( array &$vars, OutputPage $out ) {
		$wg = F::app()->wg;
		$title = $wg->Title->getPrefixedDBkey();

		if ( $wg->enableArticleFeaturedVideo && isset( $wg->articleVideoFeaturedVideos[$title]['videoId'] ) ) {
			$vars['wgOoyalaParams'] = [
				'ooyalaPCode' => $wg->ooyalaApiConfig['pcode'],
				'ooyalaPlayerBrandingId' => $wg->ooyalaApiConfig['playerBrandingId'],
			];
			$vars['wgFeaturedVideoId'] = $wg->articleVideoFeaturedVideos[$title]['videoId'];
		}

		if ( $wg->enableArticleRelatedVideo && isset( $wg->articleVideoRelatedVideos ) ) {
			$relatedVideo = ArticleVideoController::getRelatedVideoData( $wg->articleVideoRelatedVideos, $title );

			if ( isset( $relatedVideo['videoId'] ) ) {
				$vars['wgOoyalaParams'] = [
					'ooyalaPCode' => $wg->ooyalaApiConfig['pcode'],
					'ooyalaPlayerBrandingId' => $wg->ooyalaApiConfig['playerBrandingId'],
				];
				$vars['wgRelatedVideoId'] = $relatedVideo['videoId'];
			}
		}

		return true;
	}
}
