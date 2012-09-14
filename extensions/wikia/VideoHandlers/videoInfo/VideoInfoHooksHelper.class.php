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
		$title = $file->getTitle();
		if ( $title instanceof Title && F::build( 'WikiaFileHelper', array( $file ), 'isFileTypeVideo' ) ) {
			$mediaService = F::build( 'MediaQueryService' );

			$videoInfoHelper = F::build( 'VideoInfoHelper' );
			$videoData = $videoInfoHelper->getVideoDataByTitle( $title );
			if ( !empty($videoData) ) {
				$videoInfo = F::build( 'VideoInfo', array( $videoData ) );
				if ( $reupload ) {
					$videoInfo->reuploadVideo();
				} else {
					$videoInfo->addVideo();
				}
			}

			if ( !$reupload ) {
				$mediaService->clearCacheTotalVideos();
			}
		}

		return true;
	}

	/**
	 * Hook: clear cache for premium videos
	 * @param type $article
	 * @param type $user
	 * @param type $revision
	 * @param type $status
	 * @return true 
	 */
	public static function onArticleSaveComplete( $article, $user, $revision, $status ) {
		$insertedImages = Wikia::getVar( 'imageInserts' );
		$imageDeletes = Wikia::getVar( 'imageDeletes' );

		$changedImages = $imageDeletes;
		foreach( $insertedImages as $img ) {
			$changedImages[ $img['il_to'] ] = true;
		}

		foreach( $changedImages as $imageDBName => $dummy ) {
			$title = F::build( 'Title', array( NS_FILE, $imageDBName ), 'makeTitle' );
			if ( $title instanceof Title ) {
				$file = wfFindFile( $title );
				if ( $file instanceof File && $file->exists() && !$file->isLocal()
					&& F::build( 'WikiaFileHelper', array( $file ), 'isFileTypeVideo' ) ) {
					$mediaService = F::build( 'MediaQueryService' );
					$mediaService->clearCacheTotalVideos();
					break;
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
		$title = $file->getTitle();
		if ( $title instanceof Title && F::build( 'WikiaFileHelper', array( $file ), 'isFileTypeVideo' ) ) {
			$mediaService = F::build( 'MediaQueryService' );
			if ( $file->isLocal() ) {
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
		$mediaService = F::build( 'MediaQueryService' );
		$mediaService->clearCacheTotalVideos();

		return true;
	}

	/**
	 * Hook: clear cache when file is renamed
	 * @param type $form
	 * @param type $oldTitle
	 * @param type $newTitle
	 * @return true
	 */
	public static function onFileRenameComplete( &$form , &$oldTitle , &$newTitle ) {
		$mediaService = F::build( 'MediaQueryService' );
		//$mediaService->invalidateAllCacheVideos( $newTitle );

		return true;
	}

}
