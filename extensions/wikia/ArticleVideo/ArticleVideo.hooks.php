<?php

class ArticleVideoHooks {
	public static function onBeforePageDisplay( \OutputPage $out, \Skin $skin ) {
		$wg = F::app()->wg;
		$articleId = $wg->Title->getArticleID();

		if ( isset( $wg->articleVideoFeaturedVideos[$articleId] ) ) {
			\Wikia::addAssetsToOutput( 'article_video_scss' );
			\Wikia::addAssetsToOutput( 'article_video_js' );
		}

		return true;
	}

	public static function onMakeGlobalVariablesScript( array &$vars, OutputPage $out ) {
		$wg = F::app()->wg;
		$articleId = $wg->Title->getArticleID();

		if ( isset( $wg->articleVideoFeaturedVideos[$articleId]['videoId'] ) ) {
			$vars['wgArticleVideoData'] = [
				'videoId' => $wg->articleVideoFeaturedVideos[$articleId]['videoId'],
			];
		}

		return true;
	}

	public static function onSkinAfterBottomScripts( $skin, &$text ) {
		$wg = F::app()->wg;
		$articleId = $wg->Title->getArticleID();

		if ( isset( $wg->articleVideoFeaturedVideos[$articleId] ) ) {
			$text .= Html::linkedScript( OoyalaVideoHandler::getOoyalaScriptUrl() );
		}

		return true;
	}
}
