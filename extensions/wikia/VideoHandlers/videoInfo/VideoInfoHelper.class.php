<?php

/**
 * VideosInfo Helper
 * @author Garth Webb, Hyun Lim, Liz Lee, Saipetch Kongkatong
 */
class VideoInfoHelper extends WikiaModel {

	/**
	 * get video data from title
	 * @param Title|string $title
	 * @return array|null  $video
	 */
	public function getVideoDataFromTitle( $title ) {
		wfProfileIn( __METHOD__ );

		if ( is_string($title) ) {
			$title = Title::newFromText( $title, NS_FILE );
		}

		$file = wfFindFile( $title );
		$video = $this->getVideoDataFromFile( $file );

		wfProfileOut( __METHOD__ );

		return $video;
	}

	/**
	 * This method pulls the data needed for a VideoInfo object from an existing file when the data does not exist
	 * in the video_info table.  This is used in the case where video_info data wasn't created when the video uploaded.
	 * @param File $file - The file object to get video info for
	 * @return array|null - An array of data suitable for passing to the VideoInfo constructor
	 */
	public function getVideoDataFromFile( $file ) {
		if ( $file instanceof File && $file->exists() && $file->isLocal() && WikiaFileHelper::isFileTypeVideo( $file ) ) {
			$fileMetadata = $file->getMetadata();
			$userId = $file->getUser( 'id' );
			$addedAt = ( $file->getTimestamp() ) ? $file->getTimestamp() : wfTimestamp( TS_MW );

			$duration = 0;
			$videoId = '';
			if ( $fileMetadata ) {
				$fileMetadata = unserialize( $fileMetadata );
				if ( array_key_exists( 'duration', $fileMetadata ) ) {
					$duration = $fileMetadata['duration'];
				}

				if ( array_key_exists( 'videoId', $fileMetadata ) ) {
					$videoId = $fileMetadata['videoId'];
				}
			}

			return [
				'videoTitle' => $file->getName(),
				'videoId' => $videoId,
				'provider' => $file->minor_mime,
				'addedAt' => $addedAt,
				'addedBy' => $userId,
				'duration' => $duration,
			];
		}

		return [];
	}

	/**
	 * Get a VideoInfo object given a Title object
	 * @param Title|string $title
	 * @return VideoInfo|null $videoInfo
	 */
	public function getVideoInfoFromTitle( $title ) {
		wfProfileIn( __METHOD__ );

		// Attempt to retrieve this information from the video_info table first
		$videoInfo = VideoInfo::newFromTitle( $title instanceof Title ? $title->getDBkey() : $title );

		// If its not in the DB, recreate it from existing file data
		if ( empty($videoInfo) ) {
			$videoData = $this->getVideoDataFromTitle( $title );
			if ( !empty($videoData) ) {
				$videoInfo = new VideoInfo( $videoData );
			}
		}

		wfProfileOut( __METHOD__ );

		return $videoInfo;
	}

	/**
	 * get total views of a video from database using title
	 * @param $title
	 * @return int $viewCount
	 */
	public static function getTotalViewsFromTitle( $title ) {
		wfProfileIn( __METHOD__ );

		$db = wfGetDB( DB_SLAVE );

		$result = $db->select(
			array( 'video_info' ),
			array( 'views_total' ),
			array( 'video_title' => $title ),
			__METHOD__
		);

		$viewCount = 0;
		$row = $db->fetchObject( $result );
		if ( $row ) {
			$viewCount = $row->views_total;
		}

		wfProfileOut( __METHOD__ );

		return $viewCount;
	}

	/**
	 * check if video is removed
	 * @param Title|string $title
	 * @return boolean
	 */
	public function isVideoRemoved( $title ) {
		if ( is_string($title) ) {
			$title = Title::newFromText( $title, NS_FILE );
		}

		if ( $title instanceof Title ) {
			$videoInfo = VideoInfo::newFromTitle( $title->getDBKey() );
			if ( !empty($videoInfo) ) {
				return $videoInfo->isRemoved();
			}
		}

		return false;
	}

	/**
	 * check if video exists
	 * @param Title|string $title
	 * @return Boolean
	 */
	public function videoExists( $title ) {
		if ( is_string($title) ) {
			$title = Title::newFromText( $title, NS_FILE );
		}

		if ( $title instanceof Title ) {
			$videoInfo = VideoInfo::newFromTitle( $title->getDBKey() );
			if ( !empty($videoInfo) ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * rename video
	 * @param Title $oldTitle
	 * @param Title $newTitle
	 * @return boolean
	 */
	public function renameVideo( $oldTitle, $newTitle ) {
		wfProfileIn( __METHOD__ );

		$oldVideoInfo = VideoInfo::newFromTitle( $oldTitle->getDBKey() );

		// delete old video
		if ( !empty($oldVideoInfo) ) {
			$oldVideoInfo->deleteVideo();
		}

		// add new video
		$newVideoInfo = $this->getVideoInfoFromTitle( $newTitle );

		if ( empty($newVideoInfo) ) {
			$newVideoInfo = $oldVideoInfo;
			$newVideoInfo->setVideoTitle( $newTitle->getDBkey() );
		}

		$affected = $newVideoInfo->addVideo();

		wfProfileOut( __METHOD__ );

		return $affected;
	}

}
