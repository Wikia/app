<?php

class ArticleVideoMVPHooks {
	public static function onBeforePageDisplay( \OutputPage $out, \Skin $skin ) {
		global $wgVideoMVPArticles, $wgCityId;

		$wg = F::app()->wg;
		$articleId = $wg->Title->getArticleID();

		if ( isset( $wgVideoMVPArticles[$wgCityId] ) &&
		     isset( $wgVideoMVPArticles[$wgCityId][$articleId] )
		) {
			\Wikia::addAssetsToOutput( 'premium_mvp_scss' );
			\Wikia::addAssetsToOutput( 'premium_mvp_js' );
		}

		return true;
	}

	public static function onMakeGlobalVariablesScript( array &$vars, OutputPage $out ) {
		global $wgVideoMVPArticles, $wgCityId;

		$wg = F::app()->wg;
		$ooyalaPlayerId = $wg->OoyalaApiConfig['playerId'];
		$articleId = $vars['wgArticleId'];
		$jsFile = 'http://player.ooyala.com/v3/' . $ooyalaPlayerId . '?platform=html5-priority';

		if ( isset( $wgVideoMVPArticles[$wgCityId] ) &&
		     isset( $wgVideoMVPArticles[$wgCityId][$articleId] )
		) {
			$vars['wgArticleVideoData'] = [
				'videoId' => $wgVideoMVPArticles[$wgCityId][$articleId]['videoId'],
				'jsUrl' => $jsFile,
			];
		}

		return true;
	}
}
