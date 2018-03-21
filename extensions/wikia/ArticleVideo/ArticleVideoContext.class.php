<?php

class ArticleVideoContext {

	const ARTICLE_VIDEO_ERROR_MESSAGE = 'JWPlayer: Could not find mediaId in article-video service';
	const JWPLAYER_API_ERROR_MESSAGE = 'JWPlayer: Could not find enough playback info in JW API to play the video';

	/**
	 * to get playlist for given article: $playlist = self::RECOMMENDED_VIDEO_MAPPINGS[$cityId][$articleId]
	 */
	const RECOMMENDED_VIDEO_MAPPINGS_POZ_DEV = [
		// harrypotter Knight_Bus
		509 => [
			509 => '1Dw2sjAj',
		]
	];

	const RECOMMENDED_VIDEO_MAPPINGS_PROD = [
		509 => [
			509 => '1Dw2sjAj',
		]
	];

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
			$logger = Wikia\Logger\WikiaLogger::instance();

			if ( empty( $videoData['mediaId'] ) ) {
				$logger->error( self::ARTICLE_VIDEO_ERROR_MESSAGE );
			}

			$details = json_decode(
				Http::get(
					'https://cdn.jwplayer.com/v2/media/' . $videoData['mediaId'],
					1
				),
				true
			);

			if ( empty( $details ) || empty( $details['playlist'] ) || empty( $details['playlist'][0] ) ) {
				$logger->error( self::JWPLAYER_API_ERROR_MESSAGE );
			} else {
				$videoData = array_merge( $videoData, $details );

				$videoData['duration'] = WikiaFileHelper::formatDuration( $details['playlist'][0]['duration'] );
				$videoData['metadata'] = self::getVideoMetaData( $videoData );
				$videoData['recommendedLabel'] = $wg->featuredVideoRecommendedVideosLabel;
				$videoData['recommendedVideoPlaylist'] = $wg->recommendedVideoPlaylist;

				$videoData = self::getVideoDataWithAttribution( $videoData );

				return $videoData;
			}
		}

		return [];
	}

	private static function getVideoDataWithAttribution( $videoData ) {
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
			'description' => $videoDetails['description'] ?? '',
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

	public static function getRecommendedVideoPlaylistId( int $pageId ): string {
		global $wgCityId, $wgWikiaEnvironment, $wgWikiaDatacenter;

		$playlist = '';

		if ( $wgWikiaEnvironment === WIKIA_ENV_DEV ) {
			if ( $wgWikiaDatacenter === WIKIA_DC_POZ ) {
				//$playlist = self::RECOMMENDED_VIDEO_MAPPINGS_POZ_DEV[$wgCityId][$pageId] ?? '';
				$playlist = self::RECOMMENDED_VIDEO_MAPPINGS_POZ_DEV[509][509] ?? '';
			}
		} else {
			$playlist = self::RECOMMENDED_VIDEO_MAPPINGS_PROD[$wgCityId][$pageId] ?? '';
		}

		return $playlist;
	}

	public static function isRecommendedVideoAvailable( int $pageId ): bool {
		return !F::app()->wg->user->isLoggedIn() && !empty( self::getRecommendedVideoPlaylistId( $pageId ) );
	}
}
