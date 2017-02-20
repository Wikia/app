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
				'videoProvider' => $wg->videoMVPArticles[$wg->cityId][$articleId]['videoProvider']
				                   ?? 'ooyala',
			];
		}

		return true;
	}

	public static function onSkinAfterBottomScripts( $skin, &$text ) {
		$wg = F::app()->wg;
		$articleId = $wg->Title->getArticleID();

		if ( isset( $wg->videoMVPArticles[$wg->cityId][$articleId] ) ) {
			if ( isset( $wg->videoMVPArticles[$wg->cityId][$articleId]['videoProvider'] ) &&
			     $wg->videoMVPArticles[$wg->cityId][$articleId]['videoProvider'] === 'youtube'
			) {
				$text .= Html::linkedScript( 'https://www.youtube.com/iframe_api' );
			} else {
				$text .= Html::linkedScript( OoyalaVideoHandler::getOoyalaScriptUrl() );
			}
		}

		return true;
	}
}
