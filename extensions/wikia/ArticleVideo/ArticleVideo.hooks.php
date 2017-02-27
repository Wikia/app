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
			];
		}

		return true;
	}

	public static function onSkinAfterBottomScripts( $skin, &$text ) {
		$wg = F::app()->wg;
		$title = $wg->Title->getPrefixedDBkey();

		if ( isset( $wg->articleVideoFeaturedVideos[$title] ) ) {
			$text .= Html::linkedScript( OoyalaVideoHandler::getOoyalaScriptUrl() );
		}

		return true;
	}
}
