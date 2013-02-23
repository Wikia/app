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
	public function getVideoDataByTitle( $title, $premiumOnly = false ) {
		$app = F::app();

		$app->wf->ProfileIn( __METHOD__ );

		if ( is_string($title) ) {
			$title = Title::newFromText( $title, NS_FILE );
		}

		$file = $app->wf->FindFile( $title );
		$video = $this->getVideoDataByFile( $file, $premiumOnly );

		$app->wf->ProfileOut( __METHOD__ );

		return $video;
	}

	/**
	 * get video data from file
	 * @param File $file
	 * @param boolean $premiumOnly
	 * @return array|null  $video
	 */
	public function getVideoDataByFile( $file, $premiumOnly = false ) {
		$app = F::app();

		$app->wf->ProfileIn( __METHOD__ );

		$video = null;

		if ( !self::videoInfoExists() ) {
			$app->wf->ProfileOut( __METHOD__ );
			return $video;
		}

		if ( $file instanceof File && $file->exists() && WikiaFileHelper::isFileTypeVideo($file) ) {
			if ( !($premiumOnly && $file->isLocal()) ) {
				$fileMetadata = $file->getMetadata();
				$userId = $file->getUser( 'id' );
				$addedAt = ( $file->getTimestamp() ) ? $file->getTimestamp() : $this->wf->Timestamp( TS_MW );

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
					'videoTitle' => $file->getTitle()->getDBKey(),
					'addedAt' => $addedAt,
					'addedBy' => $userId,
					'duration' => $duration,
					'premium' => $premium,
					'hdfile' => $hdfile,
				);
			}
		}

		$app->wf->ProfileOut( __METHOD__ );

		return $video;
	}

	/**
	 * get total view from database
	 * @return array $videoList
	 */
	public static function getTotalViewsFromDB() {
		$app = F::app();

		$app->wf->ProfileIn( __METHOD__ );

		$videoList = array();

		if ( !self::videoInfoExists() ) {
			$app->wf->ProfileOut( __METHOD__ );
			return $videoList;
		}

		$db = $app->wf->GetDB( DB_SLAVE );

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

		$app->wf->ProfileOut( __METHOD__ );

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
	 * restore video
	 * @param Title $title
	 * @return boolean $affected
	 */
	public function restoreVideo( $title ) {
		$app = F::app();

		$app->wf->ProfileIn( __METHOD__ );

		$affected = false;
		if ( $title instanceof Title ) {
			$videoInfo = VideoInfo::newFromTitle( $title->getDBKey() );
			if ( !empty($videoInfo) ) {
				$affected = $videoInfo->restoreVideo();
			}
		}

		$app->wf->ProfileOut( __METHOD__ );

		return $affected;
	}

	/**
	 * Check if Special Videos Ext is enabled and video_info table exists
	 */
	public static function videoInfoExists() {
		$app = F::app();
		$exists = false;
		if ( !empty($app->wg->enableSpecialVideosExt) ) {
			$db = $app->wf->GetDB( DB_SLAVE );
			if ( $db->tableExists( 'video_info' ) ) {
				$exists = true;
			}
		}

		return $exists;
	}
}
