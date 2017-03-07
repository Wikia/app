<?php

class ArticleVideoController extends WikiaController {
	public function featured() {
		global $wgTitle;

		$wg = $this->getApp()->wg;
		$title = $wgTitle->getPrefixedDBkey();

		$enableArticleFeaturedVideo =
			$wg->enableArticleFeaturedVideo &&
			isset( $wg->articleVideoFeaturedVideos[$title] ) &&
			$this->isFeaturedVideosValid( $wg->articleVideoFeaturedVideos[$title] );

		if ( $enableArticleFeaturedVideo ) {
			$wg->Out->addModules( 'ext.ArticleVideo' );

			// TODO: replace it with DS icon when it's ready (XW-2824)
			$this->setVal( 'closeIconUrl',
				$wg->extensionsPath . '/wikia/ArticleVideo/images/close.svg' );
			$this->setVal( 'videoDetails', $wg->articleVideoFeaturedVideos[$title] );
		} else {
			$this->skipRendering();
		}
	}

	public function related() {
		global $wgTitle;

		$wg = $this->getApp()->wg;
		$title = $wgTitle->getPrefixedDBkey();

		$relatedVideo = null;
		if ( $wg->enableArticleRelatedVideo &&
		     isset( $wg->articleVideoRelatedVideos )
		) {
			$relatedVideo =
				self::getRelatedVideoData( $wg->articleVideoRelatedVideos, $title );
		}
		$enableArticleRelatedVideo = $relatedVideo && $this->isRelatedVideosValid( $relatedVideo );

		if ( $enableArticleRelatedVideo ) {
			$this->setVal( 'relatedVideo',
				self::getRelatedVideoData( $wg->articleVideoRelatedVideos, $title ) );
		} else {
			$this->skipRendering();
		}
	}

	public static function getRelatedVideoData( $relatedVideos, $title ) {
		foreach ( $relatedVideos as $videoData ) {
			if ( isset( $videoData['articles'] ) && in_array( $title, $videoData['articles'] ) ) {
				return $videoData;
			}
		}

		return null;
	}

	private function isFeaturedVideosValid( $featuredVideo ) {
		return isset( $featuredVideo['videoId'], $featuredVideo['thumbnailUrl'] );
	}

	private function isRelatedVideosValid( $relatedVideo ) {
		return isset( $relatedVideo['articles'], $relatedVideo['videoId'] );
	}
}
