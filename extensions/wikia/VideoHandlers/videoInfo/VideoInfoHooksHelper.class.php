<?php

/**
 * VideoInfo Hooks Helper
 * @author Liz Lee, Saipetch Kongkatong
 */
class VideoInfoHooksHelper {

	/**
	 * Hook: add or reupload video and clear cache when file is uploaded
	 * @param LocalFile $file
	 * @param $reupload
	 * @param $hasDescription
	 * @return true
	 */
	public static function onFileUpload( $file, $reupload, $hasDescription ) {
		if ( !VideoInfoHelper::videoInfoExists() ) {
			return true;
		}

		$videoInfoHelper = new VideoInfoHelper();
		$videoData = $videoInfoHelper->getVideoDataByFile( $file );
		if ( !empty($videoData) ) {
			$videoInfo = new VideoInfo( $videoData );
			if ( $reupload ) {
				$videoInfo->reuploadVideo();
			} else {
				$videoInfo->addVideo();

				$mediaService = new MediaQueryService();
				$mediaService->clearCacheTotalVideos();
				if ( !$file->isLocal() ) {
					$mediaService->clearCacheTotalPremiumVideos();
				}
			}
		}

		return true;
	}

	/**
	 * Hook: add premium video and clear cache (video embed tool, video service)
	 * @param Title $title
	 * @return true
	 */
	public static function onAddPremiumVideo( $title ) {
		if ( !VideoInfoHelper::videoInfoExists() ) {
			return true;
		}

		if ( $title instanceof Title ) {
			$videoInfoHelper = new VideoInfoHelper();
			$videoData = $videoInfoHelper->getVideoDataByTitle( $title, true );
			if ( !empty($videoData) ) {
				$videoInfo = new VideoInfo( $videoData );
				$affected = $videoInfo->addPremiumVideo( F::app()->wg->User->getId() );

				if ( $affected ) {
					$mediaService = new MediaQueryService();
					$mediaService->clearCacheTotalVideos();
					$mediaService->clearCacheTotalPremiumVideos();
				}
			}
		}

		return true;
	}

	/**
	 * Hook: add premium video and clear cache (editor - source mode)
	 * @param Article $article
	 * @param User $user
	 * @param $text
	 * @param $summary
	 * @param $minoredit
	 * @param $watchthis
	 * @param $sectionanchor
	 * @param $flags
	 * @param $revision
	 * @param $status
	 * @param $baseRevId
	 * @return true
	 */
	public static function onArticleSaveComplete(&$article, &$user, $text, $summary, $minoredit, $watchthis, $sectionanchor, &$flags, $revision, &$status, $baseRevId) {
		if ( !VideoInfoHelper::videoInfoExists() ) {
			return true;
		}

		$insertedImages = Wikia::getVar( 'imageInserts' );

		$affected = false;
		$userId = $user->getId();
		$videoInfoHelper = new VideoInfoHelper();
		foreach( $insertedImages as $img ) {
			$videoData = $videoInfoHelper->getVideoDataByTitle( $img['il_to'], true );
			if ( !empty($videoData) ) {
				$videoInfo = new VideoInfo( $videoData );
				if ( $videoInfo->addPremiumVideo( $userId ) ) {
					$affected = true;
				}
			}
		}

		// clear cache if premium video is added
		if ( $affected ) {
			$mediaService = new MediaQueryService();
			$mediaService->clearCacheTotalVideos();
			$mediaService->clearCacheTotalPremiumVideos();
		}

		return true;
	}

	/**
	 * Hook: delete video and clear cache when file is deleted
	 * @param LocalFile $file
	 * @param $oldimage
	 * @param $article
	 * @param User $user
	 * @param $reason
	 * @return true
	 */
	public static function onFileDeleteComplete( &$file, $oldimage, $article, $user, $reason ) {
		if ( !VideoInfoHelper::videoInfoExists() ) {
			return true;
		}

		$title = $file->getTitle();
		if ( $title instanceof Title && WikiaFileHelper::isFileTypeVideo($file) ) {
			if ( $file->isLocal() ) {
				$videoData = array(
					'videoTitle' => $title->getDBKey(),
				);
				$videoInfo = new VideoInfo( $videoData );
				$videoInfo->deleteVideo();

				$mediaService = new MediaQueryService();
				$mediaService->clearCacheTotalVideos();
			}
		}

		return true;
	}

	/**
	 * Hook: add video and clear cache when file is restored
	 * @param Title $title
	 * @param $versions
	 * @param User $user
	 * @param $comment
	 * @return true
	 */
	public static function onFileUndeleteComplete( $title, $versions, $user, $comment ) {
		if ( !VideoInfoHelper::videoInfoExists() ) {
			return true;
		}

		$videoInfoHelper = new VideoInfoHelper();
		$videoData = $videoInfoHelper->getVideoDataByTitle( $title );
		if ( !empty($videoData) ) {
			$videoInfo = new VideoInfo( $videoData );
			$videoInfo->addVideo();

			$mediaService = new MediaQueryService();
			$mediaService->clearCacheTotalVideos();
		}

		return true;
	}

	/**
	 * Hook: add new video if old video does not exist or rename old video and clear cache when file is renamed
	 * @param $form
	 * @param Title $oldTitle
	 * @param Title $newTitle
	 * @return true
	 */
	public static function onFileRenameComplete( &$form , &$oldTitle , &$newTitle ) {
		if ( !VideoInfoHelper::videoInfoExists() ) {
			return true;
		}

		$videoInfo = VideoInfo::newFromTitle( $oldTitle->getDBKey() );
		if ( empty($videoInfo) ) {
			// add new video
			$videoInfoHelper = new VideoInfoHelper();
			$videoData = $videoInfoHelper->getVideoDataByTitle( $newTitle );
			if ( !empty($videoData) ) {
				$videoInfo = new VideoInfo( $videoData );
				$videoInfo->addVideo();

				$mediaService = new MediaQueryService();
				$mediaService->clearCacheTotalVideos();
			}
		} else {
			$videoInfo->renameVideo( $newTitle->getDBKey() );
		}

		return true;
	}

}
