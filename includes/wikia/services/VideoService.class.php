<?php

/*
 * Video Service
 */
class VideoService extends WikiaModel {

	/**
	 * add video
	 * @param type $url
	 * @return string error message or array( $videoTitle, $videoPageId, $videoProvider )
	 */
	public function addVideo( $url ) {
		$this->wf->ProfileIn( __METHOD__ );

		if ( empty( $url ) ) {
			$this->wf->ProfileOut( __METHOD__ );
			return $this->wf->Msg('videos-error-no-video-url');
		}

		try {
			if ( WikiaFileHelper::isVideoStoredAsFile() ) {
				// is it a WikiLink?
				$title = Title::newFromText($url);
				if ( !$title || !WikiaFileHelper::isTitleVideo($title) ) {
					$title = Title::newFromText( str_replace(array('[[',']]'),array('',''),$url) );
				}
				if ( !$title || !WikiaFileHelper::isTitleVideo($title) ) {
					if ( ($pos = strpos($url,'Video:')) !== false ) {
						$title = Title::newFromText( substr($url,$pos) );
					}
					elseif ( ($pos = strpos($url,'File:')) !== false ) {
						$title = Title::newFromText( substr($url,$pos) );
					}
				}
				if ( $title && WikiaFileHelper::isTitleVideo($title) ) {
					$videoTitle = $title;
					$videoPageId = $title->getArticleId();
					$videoProvider = '';
				} else {
					list($videoTitle, $videoPageId, $videoProvider) = $this->addVideoVideoHandlers( $url );
				}
			} else {
				throw new Exception( $this->wf->Msg('videos-error-old-type-video') );
			}
		} catch ( Exception $e ) {
			$this->wf->ProfileOut( __METHOD__ );
			return $e->getMessage();
		}

		$this->wf->ProfileOut( __METHOD__ );

		return array( $videoTitle, $videoPageId, $videoProvider );
	}

	protected function addVideoVideoHandlers( $url ) {
		$title = F::build( 'VideoFileUploader', array($url), 'URLtoTitle' );
		if ( !$title ) {
			throw new Exception( $this->wf->Msg('videos-error-unknown', 876463) );
		}

		return array( $title, $title->getArticleID(), null );
	}

}