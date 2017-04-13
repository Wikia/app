<?php

class ArticleVideoContext {

	/**
	 * Checks if featured video is embedded on given article
	 *
	 * @param  string $title Prefixed article title (see: Title::getPrefixedDBkey)
	 * @return bool
	 */
	public static function isFeaturedVideoEmbedded( $title ) {
		$wg = F::app()->wg;

		return $wg->enableArticleFeaturedVideo &&
			isset( $wg->articleVideoFeaturedVideos[$title] ) &&
			self::isFeaturedVideosValid( $wg->articleVideoFeaturedVideos[$title] ) &&
			!WikiaPageType::isActionPage(); // Prevents to show video on ?action=history etc.;
	}

	private static function isFeaturedVideosValid( $featuredVideo ) {
		return isset( $featuredVideo['videoId'], $featuredVideo['thumbnailUrl'] );
	}

	/**
	 * Returns related video data for given article title, empty array in case of no video
	 *
	 * @param string $title Prefixed article title (see: Title::getPrefixedDBkey)
	 * @return array Related video data, empty if not applicable
	 */
	public static function getRelatedVideoData( $title ) {
		$wg = F::app()->wg;
		$relatedVideos = $wg->articleVideoRelatedVideos;

		if (
			!empty( $wg->enableArticleRelatedVideo ) &&
			!empty( $relatedVideos )
		) {
			foreach ( $relatedVideos as $videoData ) {
				if (
					isset( $videoData['articles'], $videoData['videoId'] ) &&
					in_array( $title, $videoData['articles'] )
				) {
					return $videoData;
				}
			}
		}

		return [];
	}

	/**
	 * Checks if related video is embedded on given article
	 *
	 * @param string $title Prefixed article title (see: Title::getPrefixedDBkey)
	 * @return bool
	 */
	public static function isRelatedVideoEmbedded( $title ) {
		return !empty( static::getRelatedVideoData( $title ) );
	}
}
