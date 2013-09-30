<?php

/**
 * VideosInfo Helper
 * @author Garth Webb, Hyun Lim, Liz Lee, Saipetch Kongkatong
 */
class VideoInfoHelper extends WikiaModel {

	/**
	 * get video data from title
	 * @param Title|string $title
	 * @param boolean $premiumOnly
	 * @return array|null  $video
	 */
	public function getVideoDataFromTitle( $title, $premiumOnly = false ) {
		wfProfileIn( __METHOD__ );

		if ( is_string($title) ) {
			$title = Title::newFromText( $title, NS_FILE );
		}

		$file = wfFindFile( $title );
		$video = $this->getVideoDataFromFile( $file, $premiumOnly );

		wfProfileOut( __METHOD__ );

		return $video;
	}

	/**
	 * This method pulls the data needed for a VideoInfo object from an existing file when the data does not exist
	 * in the video_info table.  This is used in the case where video_info data wasn't created when the video uploaded.
	 * @param File $file - The file object to get video info for
	 * @param boolean $premiumOnly - If true will exit immediately if $file is a local file
	 * @return array|null - An array of data suitable for passing to the VideoInfo constructor
	 */
	public function getVideoDataFromFile( $file, $premiumOnly = false ) {
		wfProfileIn( __METHOD__ );

		$video = null;

		if ( !self::videoInfoExists() ) {
			wfProfileOut( __METHOD__ );
			return $video;
		}

		if ( $file instanceof File && $file->exists() && WikiaFileHelper::isFileTypeVideo($file) ) {
			if ( !($premiumOnly && $file->isLocal()) ) {
				$fileMetadata = $file->getMetadata();
				$userId = $file->getUser( 'id' );
				$addedAt = ( $file->getTimestamp() ) ? $file->getTimestamp() : wfTimestamp( TS_MW );

				$duration = 0;
				$hdfile = 0;
				if ( $fileMetadata ) {
					$fileMetadata = unserialize( $fileMetadata );
					if ( array_key_exists('duration', $fileMetadata) ) {
						$duration = $fileMetadata['duration'];
					}
					if ( array_key_exists('hd', $fileMetadata) ) {
						$hdfile = ( $fileMetadata['hd'] ) ? 1 : 0;
					}
				}

				$premium = ( $file->isLocal() ) ? 0 : 1 ;
				$video = array(
					'videoTitle' => $file->getName(),
					'provider' => $file->minor_mime,
					'addedAt' => $addedAt,
					'addedBy' => $userId,
					'duration' => $duration,
					'premium' => $premium,
					'hdfile' => $hdfile,
				);
			}
		}

		wfProfileOut( __METHOD__ );

		return $video;
	}

	/**
	 * Get a VideoInfo object given a Title object
	 * @param Title|string $title
	 * @param boolean $premiumOnly
	 * @return VideoInfo|null $videoInfo
	 */
	public function getVideoInfoFromTitle( $title, $premiumOnly = false ) {
		wfProfileIn( __METHOD__ );

		// Attempt to retrieve this information from the video_info table first
		$videoInfo = VideoInfo::newFromTitle( $title instanceof Title ? $title->getDBkey() : $title );

		// If its not in the DB, recreate it from existing file data
		if ( empty($videoInfo) ) {
			$videoData = $this->getVideoDataFromTitle( $title, $premiumOnly );
			if ( !empty($videoData) ) {
				$videoInfo = new VideoInfo( $videoData );
			}
		}

		wfProfileOut( __METHOD__ );

		return $videoInfo;
	}

	/**
	 * get total view from database
	 * @return array $videoList
	 */
	public static function getTotalViewsFromDB() {

		wfProfileIn( __METHOD__ );

		$videoList = array();

		if ( !self::videoInfoExists() ) {
			wfProfileOut( __METHOD__ );
			return $videoList;
		}

		$db = wfGetDB( DB_SLAVE );

		$result = $db->select(
			array( 'video_info' ),
			array( 'video_title, views_total' ),
			array( 'views_total != 0' ),
			__METHOD__
		);

		while ( $row = $db->fetchObject($result) ) {
			$hashTitle = md5( $row->video_title );
			$key = substr( $hashTitle, 0, 2 );
			$videoList[$key][$hashTitle] = $row->views_total;
		}

		wfProfileOut( __METHOD__ );

		return $videoList;
	}

	/**
	 * check if video is removed
	 * @param Title|string $title
	 * @return boolean
	 */
	public function isVideoRemoved( $title ) {
		if ( !self::videoInfoExists() ) {
			return false;
		}

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
	 * @param Boolean $premiumOnly
	 * @return Boolean
	 */
	public function videoExists( $title, $premiumOnly = false ) {
		if ( !self::videoInfoExists() ) {
			return false;
		}

		if ( is_string($title) ) {
			$title = Title::newFromText( $title, NS_FILE );
		}

		if ( $title instanceof Title ) {
			$videoInfo = VideoInfo::newFromTitle( $title->getDBKey() );
			if ( !empty($videoInfo) ) {
				if ( $premiumOnly ) {
					return $videoInfo->isPremium();
				}

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

		$affected = false;
		$videoInfo = VideoInfo::newFromTitle( $oldTitle->getDBKey() );

		// delete old video
		if ( !empty($videoInfo) ) {
			$videoInfo->deleteVideo();
		}

		// add new video
		$videoInfo = $this->getVideoInfoFromTitle( $newTitle );
		if ( !empty($videoInfo) ) {
			$affected = $videoInfo->addVideo();
		}

		wfProfileOut( __METHOD__ );

		return $affected;
	}

	/**
	 * restore premium video
	 * @param Title $title
	 * @param integer $userId
	 * @return boolean $affected
	 */
	public function restorePremiumVideo( $title, $userId ) {
		wfProfileIn( __METHOD__ );

		$affected = false;
		if ( $title instanceof Title ) {
			$videoInfo = VideoInfo::newFromTitle( $title->getDBKey() );
			if ( empty($videoInfo) ) {
				$newVideoInfo = $this->getVideoInfoFromTitle( $title, true );
				if ( !empty($newVideoInfo) ) {
					// add premium video if not exist
					$affected = $newVideoInfo->addPremiumVideo( $userId );
				}
			} else {
				$affected = $videoInfo->restoreVideo();
			}
		}

		wfProfileOut( __METHOD__ );

		return $affected;
	}

	/**
	 * Check if Special Videos Ext is enabled and video_info table exists
	 */
	public static function videoInfoExists() {
		global $wgVideoInfoExists;

		if ( $wgVideoInfoExists !== null ) {
			return  $wgVideoInfoExists;
		}
		$app = F::app();
		$wgVideoInfoExists = false;
		if ( !empty($app->wg->enableSpecialVideosExt) ) {
			$db = wfGetDB( DB_SLAVE );
			if ( $db->tableExists( 'video_info' ) ) {
				$wgVideoInfoExists = true;
			}
		}

		return $wgVideoInfoExists;
	}
}
