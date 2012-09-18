<?php

/**
 * VideosInfo Helper
 * @author Liz Lee, Saipetch Kongkatong
 */
class VideoInfoHelper extends WikiaModel {

	/**
	 * get video data from title
	 * @param Title or string $title
	 * @return array or null  $video
	 */
	public function getVideoDataByTitle( $title ) {
		$app = F::app();

		$app->wf->ProfileIn( __METHOD__ );

		$video = null;

		if ( is_string($title) ) {
			$title = F::build( 'Title', array( $title, NS_FILE ), 'newFromText' );
		}

		$file = $app->wf->FindFile( $title );
		if ( $file instanceof File && $file->exists()
			&& F::build( 'WikiaFileHelper', array($file), 'isFileTypeVideo' ) ) {
			$fileMetadata = $file->getMetadata();
			$userId = $file->getUser( 'id' );
			$addedAt = ( $file->getTimestamp() ) ? $file->getTimestamp() : time();

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
				'videoTitle' => $title->getDBKey(),
				'addedAt' => $addedAt,
				'addedBy' => $userId,
				'duration' => $duration,
				'premium' => $premium,
				'hdfile' => $hdfile,
			);
		}

		$app->wf->ProfileOut( __METHOD__ );

		return $video;
	}

	// check if video_info table exists
	public static function videoInfoExists() {
		$db = F::app()->wf->GetDB( DB_SLAVE );
		$exists = ( $db->tableExists( 'video_info' ) ) ? true : false ;

		return $exists;
	}
}