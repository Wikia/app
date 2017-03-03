<?php

class ArticleVideoHooks {
	public static function onBeforePageDisplay( \OutputPage $out, \Skin $skin ) {
		$wg = F::app()->wg;
		$title = $wg->Title->getPrefixedDBkey();

		if ( isset( $wg->articleVideoFeaturedVideos[$title] ) ) {
			\Wikia::addAssetsToOutput( 'article_video_scss' );
			\Wikia::addAssetsToOutput( 'article_video_js' );
		}

		return true;
	}

	public static function onMakeGlobalVariablesScript( array &$vars, OutputPage $out ) {
		$wg = F::app()->wg;
		$title = $wg->Title->getPrefixedDBkey();

		if ( isset( $wg->articleVideoFeaturedVideos[$title]['videoId'] ) ) {
			$vars['wgArticleVideoData'] = [
				'videoId' => $wg->articleVideoFeaturedVideos[$title]['videoId'],
				'playerParams' => [
					'ooyalaPCode' => $wg->ooyalaApiConfig['pcode'],
					'ooyalaPlayerBrandingId' => $wg->ooyalaApiConfig['playerBrandingId'],
				],
			];
		}

		if ( isset( $wg->articleVideoRelatedVideos ) ) {
			$relatedVideo = ArticleVideoController::getRelatedVideoData( $wg->articleVideoRelatedVideos, $title );

			if ( isset( $relatedVideo['videoId'] ) ) {
				$vars['wgArticleRelatedVideoData'] = [
					'videoId' => $relatedVideo['videoId'],
				];
			}
		}

		return true;
	}
}
