<?php

class ArticleVideoController extends WikiaController {
	public function featured() {
		$wg = $this->getApp()->wg;
		$title = $wg->Title->getPrefixedDBkey();

		$featuredVideoData = ArticleVideoContext::getFeaturedVideoData( $title );

		if ( !empty( $featuredVideoData ) ) {
			$wg->Out->addModules( 'ext.ArticleVideo' );

			// TODO: replace it with DS icon when it's ready (XW-2824)
			$this->setVal( 'closeIconUrl', $wg->extensionsPath . '/wikia/ArticleVideo/images/close.svg' );
			$this->setVal( 'videoDetails', $featuredVideoData );
		} else {
			$this->skipRendering();
		}
	}

	public function related() {
		$wg = $this->getApp()->wg;
		$title = $wg->Title->getPrefixedDBkey();

		$relatedVideo = ArticleVideoContext::getRelatedVideoData( $title );

		if ( !empty( $relatedVideo ) ) {
			$this->setVal( 'relatedVideo', $relatedVideo );
		} else {
			$this->skipRendering();
		}
	}
}
