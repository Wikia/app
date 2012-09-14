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
			&& F::build( 'WikiaFileHelper', array($title), 'isTitleVideo' ) ) {
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

	public function addVideo( $title ) {
		$videoData = $this->getVideoDataByTitle( $title );
		if ( !empty($videoData) ) {
			$videoInfo = F::build( 'VideoInfo', array( $videoData ) );
			if ( $reupload ) {
				$videoInfo->reuploadVideo();
			} else {
				$videoInfo->addVideo();
			}
		}
	}

}