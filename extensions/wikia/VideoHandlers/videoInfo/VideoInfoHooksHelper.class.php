<?php

use Wikia\Logger\WikiaLogger;

/**
 * VideoInfo Hooks Helper
 * @author Liz Lee, Saipetch Kongkatong
 */
class VideoInfoHooksHelper {

	/**
	 * Insert or update video info record from given file
	 * @param LocalFile $file
	 * @param bool $reupload
	 * @return bool
	 * @throws Exception
	 */
	public static function upsertVideoInfo( \LocalFile $file, $reupload ) {
		if ( !$file->isDataLoaded() ) {
			$errMessage = 'Video file not loaded';
			WikiaLogger::instance()->error($errMessage);
			throw new \Exception($errMessage);
		}

		$videoInfoHelper = new VideoInfoHelper();
		$videoData = $videoInfoHelper->getVideoDataFromFile( $file );

		if ( empty( $videoData ) ) {
			return true;
		}

		$videoInfo = new VideoInfo( $videoData );

		// Force a reupload if the foreign video with the same title exists
		$reupload = $reupload || $videoInfoHelper->videoExists( $file->getTitle() , true );

		if ( $reupload ) {
			$videoInfo->reuploadVideo();
		} else {
			$videoInfo->addVideo();
		}

		return true;
	}

	/**
	 * Clear cache of video info specific to given file
	 * @param LocalFile $file
	 * @return bool
	 */
	public static function purgeVideoInfoCache( \LocalFile $file ) {
		$mediaService = new MediaQueryService();
		$mediaService->clearCacheTotalVideos();

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
	 * @return bool true
	 */
	public static function onFileRenameComplete( MovePageForm $form , Title $oldTitle , Title $newTitle ): bool {
		// Nothing to do if the page being renamed is not a file at all (IW-4212)
		if ( !$oldTitle->inNamespace( NS_FILE ) ) {
			return true;
		}

		$file = wfFindFile( $oldTitle );

		// Nothing to do if the page being renamed is not a video (IW-4212)
		if ( !WikiaFileHelper::isVideoFile( $file ) ) {
			return true;
		}

		$videoInfoHelper = new VideoInfoHelper();
		$affected = $videoInfoHelper->renameVideo( $oldTitle, $newTitle );
		if ( $affected ) {
			$mediaService = new MediaQueryService();
			$mediaService->clearCacheTotalVideos();
		}

		return true;
	}

	/**
	 * Hook: check if the file is deleted
	 * @todo re-implement this w/o reliance on request origination data
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
		$title = $req->getVal( 'title', '' );
		if ( $controller == 'VideoEmbedTool'
			 || $method == 'insertVideo'
			 || $title == 'Special:WikiaVideoAdd'
			 || ( $controller == 'Videos' && $method == 'addVideo' )
			 || ( $controller == 'Lightbox' && $method = 'getMediaDetail' )
		) {
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
