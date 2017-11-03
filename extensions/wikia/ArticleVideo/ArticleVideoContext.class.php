<?php

class ArticleVideoContext {

	/**
	 * Checks if featured video is embedded on given article
	 *
	 * @param  string $title Prefixed article title (see: Title::getPrefixedDBkey)
	 *
	 * @return bool
	 */
	public static function isFeaturedVideoEmbedded( $title ) {
		$wg = F::app()->wg;

		if ( !$wg->enableArticleFeaturedVideo ) {
			return false;
		}

		$featuredVideos = self::getFeaturedVideos();

		return isset( $featuredVideos[$title] ) &&
			self::isFeaturedVideosValid( $featuredVideos[$title] ) &&
			// Prevents to show video on ?action=history etc.
			!WikiaPageType::isActionPage();
	}

	/**
	 * We are temporarily using two variables for storing the videos data
	 * as we've run out of memory for one WF field. This will be replaced
	 * soon by introducing a service to handle featured videos
	 *
	 * @return array
	 */
	public static function getFeaturedVideos() {
		$wg = F::app()->wg;

		return array_merge(
			$wg->articleVideoFeaturedVideos,
			$wg->articleVideoFeaturedVideos2
		);
	}

	/**
	 * Gets video id and labels for featured video
	 *
	 * @param string $title Prefixed article title (see: Title::getPrefixedDBkey)
	 *
	 * @return array
	 */
	public static function getFeaturedVideoData( $title ) {
		$wg = F::app()->wg;

		if ( self::isFeaturedVideoEmbedded( $title ) ) {
			$videoData = self::getFeaturedVideos()[$title];

			$details = json_decode(
				Http::get(
					'https://cdn.jwplayer.com/v2/media/' . $videoData['mediaId'],
					1
				),
				true
			);
			if ( !empty( $details ) ) {
				$videoData = array_merge( $videoData, $details );
				$videoData['duration'] = WikiaFileHelper::formatDuration( $details['playlist'][0]['duration'] );
			}

			$videoData['recommendedLabel'] = $wg->featuredVideoRecommendedVideosLabel;
			$videoData['recommendedVideoPlaylist'] = $wg->recommendedVideoPlaylist;
			$videoData['dfpContentSourceId'] = $wg->AdDriverDfpOoyalaContentSourceId;

			return $videoData;
		}

		return [];
	}

	private static function isFeaturedVideosValid( $featuredVideo ) {
		return isset( $featuredVideo['mediaId'] );
	}

	/**
	 * Returns related video data for given article title, empty array in case of no video
	 *
	 * @param string $title Prefixed article title (see: Title::getPrefixedDBkey)
	 *
	 * @return array Related video data, empty if not applicable
	 */
	public static function getRelatedVideoData( $title ) {
		$wg = F::app()->wg;
		$relatedVideos = $wg->articleVideoRelatedVideos;

		if ( !empty( $wg->enableArticleRelatedVideo ) && !empty( $relatedVideos ) ) {
			foreach ( $relatedVideos as $videoData ) {
				if ( isset( $videoData['articles'], $videoData['videoId'] ) &&
					in_array( $title, $videoData['articles'] )
				) {
					return $videoData;
				}
			}
		}

		return [];
	}
}
