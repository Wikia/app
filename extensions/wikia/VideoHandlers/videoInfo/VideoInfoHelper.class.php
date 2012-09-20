<?php

/**
 * VideosInfo Helper
 * @author Liz Lee, Saipetch Kongkatong
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
			$title = F::build( 'Title', array( $title, NS_FILE ), 'newFromText' );
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

		if ( $file instanceof File && $file->exists()
			&& F::build( 'WikiaFileHelper', array($file), 'isFileTypeVideo' ) ) {
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
	 * Check if video_info table exists
	 */
	public static function videoInfoExists() {
		$db = F::app()->wf->GetDB( DB_SLAVE );
		$exists = ( $db->tableExists( 'video_info' ) ) ? true : false ;

		return $exists;
	}
}
