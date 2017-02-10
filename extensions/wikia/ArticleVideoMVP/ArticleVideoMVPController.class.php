<?php

class ArticleVideoMVPController extends WikiaController {
	public function index() {
		global $wgVideoMVPArticles, $wgCityId;
		$articleId = RequestContext::getMain()->getTitle()->getArticleID();

		$this->setVal('videoDetails', $wgVideoMVPArticles[$wgCityId][$articleId]);
	}
}
