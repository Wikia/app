<?php

class ArticleVideoHooks {
	public static function onBeforePageDisplay( \OutputPage $out, \Skin $skin ) {
		$wg = F::app()->wg;
		$articleId = $wg->Title->getArticleID();

		if ( isset( $wg->videoMVPArticles[$wg->cityId][$articleId] )
		) {
			\Wikia::addAssetsToOutput( 'article_video_scss' );
			\Wikia::addAssetsToOutput( 'article_video_js' );
		}

		return true;
	}

	public static function onMakeGlobalVariablesScript( array &$vars, OutputPage $out ) {
		$wg = F::app()->wg;
		$articleId = $wg->Title->getArticleID();
		$jsFile = OoyalaVideoHandler::getOoyalaScriptUrl();

		if ( isset( $wg->videoMVPArticles[$wg->cityId][$articleId] )
		) {
			$vars['wgArticleVideoData'] = [
				'videoId' => $wg->videoMVPArticles[$wg->cityId][$articleId]['videoId'],
				'jsUrl' => $jsFile,
			];
		}

		return true;
	}
}
