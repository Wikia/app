<?php

/**
 * VideoInfo Hooks Helper
 * @author Liz Lee, Saipetch Kongkatong
 */
class VideoInfoHooksHelper {

	/**
	 * Hook: clear cache when file is uploaded
	 * @param $file LocalFile
	 * @param $reupload
	 * @param $hasDescription
	 * @return true
	 */
	public static function onFileUpload( $file, $reupload, $hasDescription ) {
		if ( !F::build( 'VideoInfoHelper', array(), 'videoInfoExists' ) ) {
			return true;
		}

		$title = $file->getTitle();
		$videoInfoHelper = F::build( 'VideoInfoHelper' );
		$videoData = $videoInfoHelper->getVideoDataByTitle( $title );
		if ( !empty($videoData) ) {
			$videoInfo = F::build( 'VideoInfo', array( $videoData ) );
			if ( $reupload ) {
				$videoInfo->reuploadVideo();
			} else {
				$videoInfo->addVideo();

				$mediaService = F::build( 'MediaQueryService' );
				$mediaService->clearCacheTotalVideos();
				if ( !$file->isLocal() ) {
					$mediaService->clearCacheTotalPremiumVideos();
				}
			}
		}

		return true;
	}

	/**
	 * Hook: clear cache when file is deleted
	 * @param $file LocalFile
	 * @param $oldimage
	 * @param $article
	 * @param $user User
	 * @param $reason
	 * @return true
	 */
	public static function onFileDeleteComplete( &$file, $oldimage, $article, $user, $reason ) {
		if ( !F::build( 'VideoInfoHelper', array(), 'videoInfoExists' ) ) {
			return true;
		}

		$title = $file->getTitle();
		if ( $title instanceof Title && F::build( 'WikiaFileHelper', array( $file ), 'isFileTypeVideo' ) ) {
			if ( $file->isLocal() ) {
				$videoData = array(
					'videoTitle' => $title->getDBKey(),
				);
				$videoInfo = F::build( 'VideoInfo', array( $videoData ) );
				$videoInfo->deleteVideo();

				$mediaService = F::build( 'MediaQueryService' );
				$mediaService->clearCacheTotalVideos();
			}
		}

		return true;
	}

	/**
	 * Hook: clear cache when file is restored
	 * @param Title $title
	 * @param type $versions
	 * @param User $user
	 * @param type $comment
	 * @return true 
	 */
	public static function onFileUndeleteComplete( $title, $versions, $user, $comment ) {
		if ( !F::build( 'VideoInfoHelper', array(), 'videoInfoExists' ) ) {
			return true;
		}

		$videoInfoHelper = F::build( 'VideoInfoHelper' );
		$videoData = $videoInfoHelper->getVideoDataByTitle( $title );
		if ( !empty($videoData) ) {
			$videoInfo = F::build( 'VideoInfo', array( $videoData ) );
			$videoInfo->addVideo();

			$mediaService = F::build( 'MediaQueryService' );
			$mediaService->clearCacheTotalVideos();
		}

		return true;
	}

	/**
	 * Hook: clear cache when file is renamed
	 * @param type $form
	 * @param Title $oldTitle
	 * @param Title $newTitle
	 * @return true
	 */
	public static function onFileRenameComplete( &$form , &$oldTitle , &$newTitle ) {
		if ( !F::build( 'VideoInfoHelper', array(), 'videoInfoExists' ) ) {
			return true;
		}

		$videoInfo = F::build( 'VideoInfo', array($oldTitle->getDBKey()), 'newFromTitle' );
		if ( empty($videoInfo) ) {
			// add new video
			$videoInfoHelper = F::build( 'VideoInfoHelper' );
			$videoData = $videoInfoHelper->getVideoDataByTitle( $newTitle );
			if ( !empty($videoData) ) {
				$videoInfo = F::build( 'VideoInfo', array( $videoData ) );
				$videoInfo->addVideo();

				$mediaService = F::build( 'MediaQueryService' );
				$mediaService->clearCacheTotalVideos();
			}
		} else {
			$videoInfo->renameVideo( $newTitle->getDBKey() );
		}

		return true;
	}

}
