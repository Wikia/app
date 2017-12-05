<?php

class ArticleVideoContext {

	/**
	 * Checks if featured video is embedded on given article
	 *
	 * @param  string $title Prefixed article title (see: Title::getPrefixedDBkey)
	 *
	 * @return bool
	 */
	public static function isFeaturedVideoEmbedded( string $prefixedDbKey ) {
		$wg = F::app()->wg;

		if ( !$wg->enableArticleFeaturedVideo ) {
			return false;
		}

		$featuredVideos = self::getFeaturedVideos();

		return isset( $featuredVideos[$prefixedDbKey] ) &&
			self::isFeaturedVideosValid( $featuredVideos[$prefixedDbKey] ) &&
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
	 * @param string $prefixedDbKey Prefixed article title (see: Title::getPrefixedDBkey)
	 *
	 * @return array
	 */
	public static function getFeaturedVideoData( string $prefixedDbKey ) {
		$wg = F::app()->wg;

		if ( self::isFeaturedVideoEmbedded( $prefixedDbKey ) ) {
			$videoData = self::getFeaturedVideos()[$prefixedDbKey];

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
			$videoData['metadata'] = self::getVideoMetaData( $videoData );

			return $videoData;
		}

		return [];
	}

	private static function getVideoMetaData( $videoDetails ) {
		$playlistItem = $videoDetails['playlist'][0];

		return [
			'name' => $videoDetails['title'],
			'thumbnailUrl' => $playlistItem['image'],
			'uploadDate' => date( 'c', $playlistItem['pubdate'] ),
			'duration' => self::getIsoTime( $videoDetails['duration'] ),
			'description' => $videoDetails['description'],
			'contentUrl' => self::getVideoContentUrl( $playlistItem['sources'] )
		];
	}

	private static function getVideoContentUrl( $sources ) {
		return $sources[count( $sources ) - 1]['file'];
	}

	private static function getIsoTime( $colonDelimitedTime ) {
		$segments = explode( ':', $colonDelimitedTime );
		$isoTime = '';

		if ( count( $segments ) > 2 ) {
			$isoTime = 'H' . $segments[0] . 'M' . $segments[1] . 'S' . $segments[2];
		} else if ( count( $segments ) > 1 ) {
			$isoTime = 'M' . $segments[0] . 'S' . $segments[1];
		} else if ( count( $segments ) > 0 ) {
			$isoTime = 'S' . $segments[0];
		}

		return $isoTime;
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
					in_array( $title, $videoData['articles'] ) ) {
					return $videoData;
				}
			}
		}

		return [];
	}
}
