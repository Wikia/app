<?php

class ArticleVideoController extends WikiaController {
	public function index() {
		$wg = F::app()->wg;

		$articleId = RequestContext::getMain()->getTitle()->getArticleID();

		$this->setVal( 'thumbnailUrl', $wg->articleVideoFeaturedVideos[$articleId]['thumbnailUrl'] );

		// TODO: replace it with DS icon when it's ready (XW-2824)
		$this->setVal( 'closeIconUrl',
			$wg->extensionsPath . '/wikia/ArticleVideo/images/close.svg' );
		$this->setVal( 'videoPlayButtonUrl',
			$wg->extensionsPath . '/wikia/ArticleVideo/images/play-button-solid.svg' );
		$this->setVal( 'videoDetails', $wg->articleVideoFeaturedVideos[$articleId] );
	}
}
