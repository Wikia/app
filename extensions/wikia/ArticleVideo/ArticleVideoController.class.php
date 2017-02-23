<?php

class ArticleVideoController extends WikiaController {
	public function index() {
		$wg = F::app()->wg;

		$articleId = RequestContext::getMain()->getTitle()->getArticleID();
		$thumbnailPath = $wg->videoMVPArticles[$wg->cityId][$articleId]['thumbnailPath'];
		$countdownMode = $_GET['countdown'] ?? 1;
		$countdownClass = '';

		switch($countdownMode) {
			case 2:
				$countdownClass = 'countdown-steps-5';
				break;
			case 3:
				$countdownClass = 'countdown-steps-50';
				break;
			case 4:
				$countdownClass = 'countdown-timer';
				break;
		}

		$this->setVal( 'countdownClass', $countdownClass );
		$this->setVal( 'thumbnailUrl', $wg->extensionsPath . $thumbnailPath );

		// TODO: replace it with DS icon when it's ready (XW-2824)
		$this->setVal( 'closeIconUrl',
			$wg->extensionsPath . '/wikia/ArticleVideo/images/close.svg' );
		$this->setVal( 'videoDetails', $wg->videoMVPArticles[$wg->cityId][$articleId] );
	}
}
