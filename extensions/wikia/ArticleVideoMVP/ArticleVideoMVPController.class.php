<?php

class ArticleVideoMVPController extends WikiaController {
	public function index() {
		$wg = F::app()->wg;

		$articleId = RequestContext::getMain()->getTitle()->getArticleID();
		$thumbnailPath = $wg->videoMVPArticles[$wg->cityId][$articleId]['thumbnailPath'];

		$this->setVal( 'thumbnailUrl', $wg->extensionsPath . $thumbnailPath );
		$this->setVal( 'videoDetails', $wg->videoMVPArticles[$wg->cityId][$articleId] );
	}
}
