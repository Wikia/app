<?php

class ArticleVideoContext {

	public static function isFeaturedVideoEmbedded( $title ) {
		$wg = F::app()->wg;

		return $wg->enableArticleFeaturedVideo &&
			isset( $wg->articleVideoFeaturedVideos[$title] ) &&
			self::isFeaturedVideosValid( $wg->articleVideoFeaturedVideos[$title] );
	}

	private static function isFeaturedVideosValid( $featuredVideo ) {
		return isset( $featuredVideo['videoId'], $featuredVideo['thumbnailUrl'] );
	}
}
