<?php

class ArticleVideoHooks {
	public static function onBeforePageDisplay( \OutputPage $out, \Skin $skin ) {
		$wg = F::app()->wg;
		$articleId = $wg->Title->getArticleID();

		if ( isset( $wg->videoMVPArticles[$wg->cityId][$articleId] ) ) {
			\Wikia::addAssetsToOutput( 'article_video_scss' );
			\Wikia::addAssetsToOutput( 'article_video_js' );
		}

		return true;
	}

	public static function onMakeGlobalVariablesScript( array &$vars, OutputPage $out ) {
		$wg = F::app()->wg;
		$articleId = $wg->Title->getArticleID();

		if ( isset( $wg->videoMVPArticles[$wg->cityId][$articleId] ) ) {
			$vars['wgArticleVideoData'] = [
				'videoId' => $wg->videoMVPArticles[$wg->cityId][$articleId]['videoId'],
			];
		}

		return true;
	}

	public static function onSkinAfterBottomScripts( $skin, &$text ) {
		$wg = F::app()->wg;
		$articleId = $wg->Title->getArticleID();

		if ( isset( $wg->videoMVPArticles[$wg->cityId][$articleId] ) ) {
			$text .= '<script>define.amd.jQuery = false;</script>' .
			         Html::linkedScript( OoyalaVideoHandler::getOoyalaScriptUrl() );
		}

		return true;
	}
}
