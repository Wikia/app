<?php

class ArticleVideoMVPController extends WikiaController {
	public function index() {
		global $wgVideoMVPArticles, $wgCityId, $wgExtensionsPath;
		$articleId = RequestContext::getMain()->getTitle()->getArticleID();
		$thumbnailPath = $wgVideoMVPArticles[$wgCityId][$articleId]['thumbnailPath'];

		$this->setVal('thumbnailUrl', $wgExtensionsPath . $thumbnailPath);
		$this->setVal('videoDetails', $wgVideoMVPArticles[$wgCityId][$articleId]);
	}
}
