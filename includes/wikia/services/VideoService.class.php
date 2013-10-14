<?php

/**
 * Video Service
 */
class VideoService extends WikiaModel {

	/**
	 * add video
	 * @param string $url
	 * @return string error message or array( $videoTitle, $videoPageId, $videoProvider )
	 */
	public function addVideo( $url ) {
		wfProfileIn( __METHOD__ );

		if ( !$this->wg->User->isAllowed('videoupload') ) {
			wfProfileOut( __METHOD__ );
			return wfMessage('videos-error-admin-only')->plain();
		}

		if ( empty( $url ) ) {
			wfProfileOut( __METHOD__ );
			return wfMessage('videos-error-no-video-url')->text();
		}

		try {
			if ( WikiaFileHelper::isVideoStoredAsFile() ) {
				// is it a WikiLink?
				$title = Title::newFromText($url, NS_FILE);
				if ( !$title || !WikiaFileHelper::isTitleVideo($title) ) {
					$title = Title::newFromText( str_replace(array('[[',']]'),array('',''),$url), NS_FILE );
				}
				if ( !$title || !WikiaFileHelper::isTitleVideo($title) ) {
					$transFileNS = wfMessage('nstab-image')->inContentLanguage()->text();

					if ( ($pos = strpos($url, 'Video:')) !== false ) {
						$title = Title::newFromText( substr($url,$pos), NS_FILE );
					} elseif ( ($pos = strpos($url, 'File:')) !== false ) {
						$title = Title::newFromText( substr($url,$pos), NS_FILE );
					} elseif ( ($pos = strpos($url, $transFileNS.':')) !== false ) {
						$title = Title::newFromText( substr($url,$pos), NS_FILE );
					}
				}
				if ( $title && WikiaFileHelper::isTitleVideo($title) ) {
					$videoTitle = $title;
					$videoPageId = $title->getArticleId();
					$videoProvider = '';
					wfRunHooks( 'AddPremiumVideo', array( $title ) );
				} else {
					if ( empty( $this->wg->allowNonPremiumVideos ) ) {
						wfProfileOut( __METHOD__ );
						return wfMessage( 'videohandler-non-premium' )->parse();
					}
					list($videoTitle, $videoPageId, $videoProvider) = $this->addVideoVideoHandlers( $url );
				}

				// Add a default description if available and one doesn't already exist
				$file = wfFindFile( $videoTitle );
				$vHelper = new VideoHandlerHelper();
				$vHelper->addDefaultVideoDescription( $file );
			} else {
				throw new Exception( wfMessage( 'videos-error-old-type-video' )->text() );
			}
		} catch ( Exception $e ) {
			wfProfileOut( __METHOD__ );
			return $e->getMessage();
		}

		wfProfileOut( __METHOD__ );

		return array( $videoTitle, $videoPageId, $videoProvider );
	}

	/**
	 * @param $url
	 * @return array
	 * @throws Exception
	 */
	protected function addVideoVideoHandlers( $url ) {
		$title = VideoFileUploader::URLtoTitle( $url );
		if ( !$title ) {
			throw new Exception( wfMessage('videos-error-invalid-video-url')->text() );
		}

		return array( $title, $title->getArticleID(), null );
	}

	/**
	 * add video to other wikis
	 * @param string $videoUrl
	 * @param array $wikis
	 * @return array|false $result
	 */
	public function addVideoAcrossWikis( $videoUrl, $wikis ) {
		wfProfileIn( __METHOD__ );

		$params = array(
			'controller' => 'VideosController',
			'method' => 'addVideo',
			'url'      => $videoUrl,
		);

		$result = false;
		foreach( $wikis as $wikiId => $wiki ) {
			$result[$wikiId] = true;
			if ( !empty( $wiki['d'] ) ) {
				$userName = $this->wg->User->getName();
				$response = ApiService::foreignCall( $wiki['d'], $params, ApiService::WIKIA, $userName );
				if ( !empty( $response['error'] ) ) {
					Wikia::log( __METHOD__, false, "Error: Cannot add video to wiki $wikiId ($response[error])", true, true);
					$result[$wikiId] = false;
				}
			}
		}

		wfProfileOut( __METHOD__ );

		return $result;
	}

}
