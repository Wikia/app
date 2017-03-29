<?php

class ArticleVideoController extends WikiaController {
	public function featured() {
		$wg = $this->getApp()->wg;
		$title = $wg->Title->getPrefixedDBkey();

		$enableArticleFeaturedVideo = ArticleVideoContext::isFeaturedVideoEmbedded( $title );

		if ( $enableArticleFeaturedVideo ) {
			$wg->Out->addModules( 'ext.ArticleVideo' );

			// TODO: replace it with DS icon when it's ready (XW-2824)
			$this->setVal( 'closeIconUrl', $wg->extensionsPath . '/wikia/ArticleVideo/images/close.svg' );
			$this->setVal( 'videoDetails', $wg->articleVideoFeaturedVideos[$title] );
		} else {
			$this->skipRendering();
		}
	}

	public function related() {
		$wg = $this->getApp()->wg;
		$title = $wg->Title->getPrefixedDBkey();

		$relatedVideo = self::getRelatedVideoData( $wg->articleVideoRelatedVideos, $title );
		$enableArticleRelatedVideo = ArticleVideoHooks::isRelatedVideoEmbedded( $relatedVideo );

		if ( $enableArticleRelatedVideo ) {
			$this->setVal( 'relatedVideo', $relatedVideo );
		} else {
			$this->skipRendering();
		}
	}

	public static function getRelatedVideoData( $relatedVideos, $title ) {
		$wg = F::app()->wg;
		if ( isset( $wg->articleVideoRelatedVideos ) ) {
			foreach ( $relatedVideos as $videoData ) {
				if ( isset( $videoData['articles'] ) &&
					in_array( $title, $videoData['articles'] )
				) {
					return $videoData;
				}
			}
		}

		return null;
	}
}
