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
		if ( !F::build( 'VideoInfoHelper', array(), 'videoInfoExists' ) ) {
			return true;
		}

		$videoInfoHelper = F::build( 'VideoInfoHelper' );
		$videoData = $videoInfoHelper->getVideoDataByFile( $file );
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
	 * Hook: add premium video and clear cache (video embed tool, video service)
	 * @param Title $title
	 * @return true
	 */
	public static function onAddPremiumVideo( $title ) {
		if ( !F::build( 'VideoInfoHelper', array(), 'videoInfoExists' ) ) {
			return true;
		}

		if ( $title instanceof Title ) {
			$videoInfoHelper = F::build( 'VideoInfoHelper' );
			$videoData = $videoInfoHelper->getVideoDataByTitle( $title, true );
			if ( !empty($videoData) ) {
				$videoInfo = F::build( 'VideoInfo', array( $videoData ) );
				$affected = $videoInfo->addPremiumVideo( F::app()->wg->User->getId() );

				if ( $affected ) {
					$mediaService = F::build( 'MediaQueryService' );
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

		// makes no sense to continue, if we're not running RelatedVideos on the wiki
		$app = F::app();
		if ( !$app->wg->EnableRelatedVideosExt ) {
			return true;
		}

		$images = array();
		$insertedImages = Wikia::getVar( 'imageInserts' );
		foreach( $insertedImages as $img ) {
			$key = md5( $img['il_to'] );
			if ( !array_key_exists($key, $images) ) {
				$images[$key] = $img['il_to'];
			}
		}

		// related videos global list
		$title = $article->getTitle();
		if ( !empty($title) ) {
			$relatedVideos = RelatedVideosNamespaceData::newFromGeneralMessage();
			if ( !empty($relatedVideos) && $title->getNamespace() == NS_MEDIAWIKI
				&& $title->getText() == RelatedVideosNamespaceData::GLOBAL_RV_LIST ) {
				$data = $relatedVideos->getData();
				if ( isset($data['lists'])
					&& isset($data['lists'][RelatedVideosNamespaceData::WHITELIST_MARKER]) ) {
					foreach( $data['lists'][RelatedVideosNamespaceData::WHITELIST_MARKER] as $page ) {
						$key = md5( $page['title'] );
						if ( !array_key_exists($key, $images) ) {
							$images[$key] = $page['title'];
						}
					}
				}
			}
		}

		$affected = false;
		$userId = $user->getId();
		$videoInfoHelper = new VideoInfoHelper();
		foreach( $images as $img ) {
			$videoData = $videoInfoHelper->getVideoDataByTitle( $img, true );
			if ( !empty($videoData) ) {
				$videoInfo = new VideoInfo( $videoData );
				$affected = $videoInfo->addPremiumVideo( $userId );
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
	 * Hook: add video and clear cache when file is restored
	 * @param Title $title
	 * @param $versions
	 * @param User $user
	 * @param $comment
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
	 * Hook: add new video if old video does not exist or rename old video and clear cache when file is renamed
	 * @param $form
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
