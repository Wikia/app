<?php

class ArticleVideoController extends WikiaController {
	public function index() {
		$wg = F::app()->wg;

		$articleId = RequestContext::getMain()->getTitle()->getArticleID();
		$thumbnailPath = $wg->videoMVPArticles[$wg->cityId][$articleId]['thumbnailPath'];

		$this->setVal( 'thumbnailUrl', $wg->extensionsPath . $thumbnailPath );
		$this->setVal( 'closeIconUrl',
			$wg->extensionsPath . '/wikia/ArticleVideo/images/close.svg' );
		$this->setVal( 'videoPlayButtonUrl',
			$wg->extensionsPath . '/wikia/ArticleVideo/images/play-button-solid.svg' );
		$this->setVal( 'videoDetails', $wg->videoMVPArticles[$wg->cityId][$articleId] );
	}
}
