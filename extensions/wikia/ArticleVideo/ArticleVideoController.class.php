<?php

class ArticleVideoController extends WikiaController {
	public function featured() {
		$wg = F::app()->wg;

		$wg->Out->addModules( 'ext.ArticleVideo' );

		$title = RequestContext::getMain()->getTitle()->getPrefixedDBkey();

		// TODO: replace it with DS icon when it's ready (XW-2824)
		$this->setVal( 'closeIconUrl',
			$wg->extensionsPath . '/wikia/ArticleVideo/images/close.svg' );
		$this->setVal( 'videoDetails', $wg->articleVideoFeaturedVideos[$title] );
	}

	public function related() {
		$wg = F::app()->wg;

		$title = RequestContext::getMain()->getTitle()->getPrefixedDBkey();

		$this->setVal( 'relatedVideo', self::getRelatedVideoData( $wg->articleVideoRelatedVideos, $title ) );
	}

	public static function getRelatedVideoData( $relatedVideos, $title ) {
		foreach ( $relatedVideos as $videoData ) {
			if ( isset( $videoData['articles'] ) && in_array( $title, $videoData['articles'] ) ) {
				return $videoData;
			}
		}

		return null;
	}
}
