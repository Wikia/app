<?php
use Wikia\Logger\WikiaLogger;

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
		global $wgIsGhostVideo;

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
			// is it a WikiLink?
			$title = Title::newFromText($url, NS_FILE);
			if ( !$title || !WikiaFileHelper::isFileTypeVideo($title) ) {
				$title = Title::newFromText( str_replace(array('[[',']]'),array('',''),$url), NS_FILE );
			}
			if ( !$title || !WikiaFileHelper::isFileTypeVideo($title) ) {
				$file = $this->getVideoFileByUrl( $url );
				if ( $file ) {
					$title = $file->getTitle();
				}
			}
			if ( $title && WikiaFileHelper::isFileTypeVideo($title) ) {
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
				//$file = wfFindFile( $videoTitle ); // <- tu sie zaczyna psuc
				$file = RepoGroup::singleton()->findFile( $videoTitle );
			}

			if ( !( $file instanceof File ) ) {
				WikiaLogger::instance()->error( '\VideoHandlerHelper->adDefaultVideoDescription() - File is empty', [
					'exception' => new Exception(),
					'url' => $url,
					'title' => $title,
					'videoTitle' => $videoTitle,
					'videoPageId' => $videoPageId,
					'videoProvider' => $videoProvider,
					'wgIsGhostVideo' => $wgIsGhostVideo
				] );
				wfProfileOut( __METHOD__ );
				return wfMessage( 'videos-something-went-wrong' )->parse();
			} else {
				// Add a default description if available and one doesn't already exist
				$vHelper = new VideoHandlerHelper();
				$vHelper->addDefaultVideoDescription( $file );
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
				$response = ApiService::foreignCall( $wiki['d'], $params, ApiService::WIKIA, true );
				if ( !empty( $response['error'] ) ) {
					Wikia::log( __METHOD__, false, "Error: Cannot add video to wiki $wikiId ($response[error])", true, true);
					$result[$wikiId] = false;
				}
			}
		}

		wfProfileOut( __METHOD__ );

		return $result;
	}

	/**
	 * Get Video file by given URL
	 * @param string $url
	 * @return File|null
	 */
	public function getVideoFileByUrl( $url ) {
		global $wgContLang;

		$file = null;

		$nsFileTranslated = $wgContLang->getNsText( NS_FILE );

		// added $nsFileTransladed to fix bugId:#48874
		$pattern = '/(File:|' . $nsFileTranslated . ':)(.+)$/';
		if ( preg_match( $pattern, $url, $matches ) ) {
			$file = wfFindFile( $matches[2] );
			if ( !$file && preg_match( $pattern, urldecode( $url ), $matches ) ) { // bugID: 26721
				$file = wfFindFile( urldecode( $matches[2] ) );
			}
		}

		return $file;
	}

}
