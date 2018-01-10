<?php

class ArticleVideoContext {

	/**
	 * Checks if featured video is embedded on given article
	 *
	 * @param $pageId
	 *
	 * @return bool
	 *
	 */
	public static function isFeaturedVideoEmbedded( string $pageId ) {
		$wg = F::app()->wg;

		if ( !$wg->enableArticleFeaturedVideo || WikiaPageType::isActionPage()) {
			return false;
		}

		$mediaId = ArticleVideoService::getFeatureVideoForArticle( $wg->cityId, $pageId );

		return !empty( $mediaId );
	}

	/**
	 * Gets video id and labels for featured video
	 *
	 * @param $pageId
	 *
	 * @return array
	 *
	 */
	public static function getFeaturedVideoData( string $pageId ) {
		$wg = F::app()->wg;

		if ( self::isFeaturedVideoEmbedded( $pageId ) ) {
			$videoData = [];
			$videoData['mediaId'] = ArticleVideoService::getFeatureVideoForArticle( $wg->cityId, $pageId );

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

			$videoData = self::getVideoDataWithAttribution( $videoData );

			return $videoData;
		}

		return [];
	}

	private static function getVideoDataWithAttribution( $videoData ) {
		if ( empty( $videoData['playlist'] ) || empty( $videoData['playlist'][0] ) ) {
			return $videoData;
		}

		$playlistVideo = $videoData['playlist'][0];

		if ( !empty( $playlistVideo['username'] ) ) {
			$videoData['username'] = $playlistVideo['username'];
		}

		if ( !empty( $playlistVideo['userUrl'] ) ) {
			$videoData['userUrl'] = $playlistVideo['userUrl'];
		}

		if ( !empty( $playlistVideo['userAvatarUrl'] ) ) {
			$videoData['userAvatarUrl'] = $playlistVideo['userAvatarUrl'];
		}

		return $videoData;
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
