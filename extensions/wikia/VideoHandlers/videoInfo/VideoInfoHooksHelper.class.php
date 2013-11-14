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

		$videoInfoHelper = new VideoInfoHelper();
		$videoData = $videoInfoHelper->getVideoDataFromFile( $file );
		if ( !empty($videoData) ) {
			$videoInfo = new VideoInfo( $videoData );
			if ( $reupload ) {
				$videoInfo->reuploadVideo();
			} else {
				// check if the foreign video with the same title exists
				if ( $videoInfoHelper->videoExists($file->getTitle(), true) ) {
					$videoInfo->reuploadVideo();
				} else {
					$videoInfo->addVideo();
				}

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

		if ( $title instanceof Title ) {
			$videoInfoHelper = new VideoInfoHelper();
			$videoInfo = $videoInfoHelper->getVideoInfoFromTitle( $title, true );
			if ( !empty($videoInfo) ) {
				// Sometimes videoInfo doesn't reflect what's actually in the video_info table
				// so make sure the removed flag is cleared
				$videoInfo->restoreVideo();

				$affected = $videoInfo->addPremiumVideo( F::app()->wg->User->getId() );

				if ( $affected ) {
					# Add a log entry
					$log = new LogPage( 'upload' );
					$comment = wfMessage('videohandler-log-add-video')->plain();
					$log->addEntry( 'upload', $title, $comment, array(), F::app()->wg->User );

					$mediaService = new MediaQueryService();
					$mediaService->clearCacheTotalVideos();
					$mediaService->clearCacheTotalPremiumVideos();
				}
			}
		}

		return true;
	}

	/**
	 * Hook: remove premium video and clear cache
	 * @param Title $title
	 * @return true
	 */
	public static function onRemovePremiumVideo( $title ) {

		if ( $title instanceof Title ) {
			$videoInfo = VideoInfo::newFromTitle( $title->getDBKey() );
			if ( !empty( $videoInfo ) && $videoInfo->isPremium() ) {
				$videoInfo->deleteVideo();

				// clear cache
				$mediaService = new MediaQueryService();
				$mediaService->clearCacheTotalVideos();
				$mediaService->clearCacheTotalPremiumVideos();
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

		$insertedImages = Wikia::getVar( 'imageInserts' );

		$affected = false;
		$userId = $user->getId();
		$videoInfoHelper = new VideoInfoHelper();
		foreach( $insertedImages as $img ) {
			$videoInfo = $videoInfoHelper->getVideoInfoFromTitle( $img['il_to'], true );
			if ( !empty($videoInfo) ) {
				$affected = ( $affected || $videoInfo->addPremiumVideo( $userId ) );
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

		if ( WikiaFileHelper::isFileTypeVideo($file) ) {
			if ( $file->isLocal() ) {
				// remove local video from video_info table
				$videoInfo = VideoInfo::newFromTitle( $file->getName() );
				if ( !empty($videoInfo) ) {
					$videoInfo->deleteVideo();

					$mediaService = new MediaQueryService();
					$mediaService->clearCacheTotalVideos();
				}
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

		$videoInfoHelper = new VideoInfoHelper();
		$videoInfo = $videoInfoHelper->getVideoInfoFromTitle( $title );
		if ( !empty($videoInfo) ) {
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

		$videoInfoHelper = new VideoInfoHelper();
		$affected = $videoInfoHelper->renameVideo( $oldTitle, $newTitle );
		if ( $affected ) {
			$mediaService = new MediaQueryService();
			$mediaService->clearCacheTotalVideos();
		}

		return true;
	}

	/**
	 * Hook: delete premium video and clear cache when the file page is deleted
	 * @param WikiPage $wikiPage
	 * @param User $user
	 * @param string $reason
	 * @param integer $pageId
	 * @return true
	 */
	public static function onArticleDeleteComplete( &$wikiPage, &$user, $reason, $pageId  ) {

		$title = $wikiPage->getTitle();
		if ( $title instanceof Title && $title->getNamespace() == NS_FILE ) {
			$videoInfo = VideoInfo::newFromTitle( $title->getDBKey() );
			if ( empty($videoInfo) ) {
				$affected = false;

				// add removed video
				$videoInfoHelper = new VideoInfoHelper();
				$videoInfo = $videoInfoHelper->getVideoInfoFromTitle( $title, true );
				if ( !empty($videoInfo) ) {
					$videoInfo->setRemoved();
					$affected = $videoInfo->addPremiumVideo( $user->getId() );
				}
			} else {
				// set removed video
				$affected = $videoInfo->removeVideo();
			}

			if ( $affected ) {
				$mediaService = new MediaQueryService();
				$mediaService->clearCacheTotalVideos();
				$mediaService->clearCacheTotalPremiumVideos();
			}
		}

		return true;
	}

	/**
	 * Hook: restore premium video and clear cache when the file page is undeleted
	 * @param Title $title
	 * @param User $user
	 * @param string $reason
	 * @return true
	 */
	public static function onUndeleteComplete( &$title, &$user, $reason ) {

		if ( $title instanceof Title && $title->getNamespace() == NS_FILE ) {
			$videoInfoHelper = new VideoInfoHelper();
			$affected = $videoInfoHelper->restorePremiumVideo( $title, $user->getId() );
			if ( $affected ) {
				$mediaService = new MediaQueryService();
				$mediaService->clearCacheTotalVideos();
				$mediaService->clearCacheTotalPremiumVideos();
			}
		}

		return true;
	}

	/**
	 * Hook: check if the file is deleted
	 * @param File $file
	 * @param boolean $isDeleted
	 * @return true
	 */
	public static function onForeignFileDeleted( $file, &$isDeleted ) {

		// Only report this file as deleted when this request is coming from a file page.  In other
		// instances (search results from the WVL for example) we want to make sure these videos still appear.
		// (VideoEmbedTool controller for search in VET, insertVideo method for add video via VET, and
		// Videos controller and addVideo method for add video in general)
		$req = F::app()->wg->Request;
		$controller = $req->getVal( 'controller', '' );
		$method = $req->getVal( 'method', '' );
		if ( $controller == 'VideoEmbedTool' || $method == 'insertVideo' || ( $controller == 'Videos' && $method == 'addVideo' ) )  {
			return true;
		}

		if ( WikiaFileHelper::isFileTypeVideo($file) && !$file->isLocal() ) {
			$videoInfoHelper = new VideoInfoHelper();
			$isDeleted = $videoInfoHelper->isVideoRemoved( $file->getName() );
		}

		return true;
	}

	/**
	 * Check the file passed and fail if its a ghost file; that is, a file
	 * that is from the video wiki but doesn't have any local record
	 *
	 * @param File $file A file object to check
	 * @return bool Whether this hook has succeeded
	 */
	public static function onCheckGhostFile( &$file ) {
		# If we're on a file page and we don't have any video_info for the current
		# title, treat it like a non-existent file
		if ( $file && WikiaFileHelper::isFileTypeVideo($file) ) {
			$title = $file->getTitle()->getDBkey();
			$info = VideoInfo::newFromTitle( $title );
			if ( empty($info) ) {
				F::app()->wg->IsGhostVideo = true;
				$file = null;
			}
		}

		return true;
	}
}
