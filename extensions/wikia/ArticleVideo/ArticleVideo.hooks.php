<?php

class ArticleVideoHooks {
	public static function onBeforePageDisplay( \OutputPage $out, \Skin $skin ) {
		$wg = F::app()->wg;
		$articleId = $wg->Title->getArticleID();

		if ( isset( $wg->featuredVideos[$articleId] ) ) {
			\Wikia::addAssetsToOutput( 'article_video_scss' );
			\Wikia::addAssetsToOutput( 'article_video_js' );
		}

		return true;
	}

	public static function onMakeGlobalVariablesScript( array &$vars, OutputPage $out ) {
		$wg = F::app()->wg;
		$articleId = $wg->Title->getArticleID();

		if ( isset( $wg->featuredVideos[$articleId]['videoId'] ) ) {
			$vars['wgArticleVideoData'] = [
				'videoId' => $wg->featuredVideos[$articleId]['videoId'],
			];
		}

		return true;
	}

	public static function onSkinAfterBottomScripts( $skin, &$text ) {
		$wg = F::app()->wg;
		$articleId = $wg->Title->getArticleID();

		if ( isset( $wg->featuredVideos[$articleId] ) ) {
			$text .= Html::linkedScript( OoyalaVideoHandler::getOoyalaScriptUrl() );
		}

		return true;
	}
}
