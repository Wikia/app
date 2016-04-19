<?php

class VideosController extends WikiaController {

	/**
	 * add video
	 * @requestParam string url
	 * @responseParam string html
	 * @responseParam string error - error message
	 */
	public function addVideo( ) {
		$this->checkWriteRequest();

		if ( !$this->wg->User->isLoggedIn() ) {
			$this->error = wfMsg( 'videos-error-not-logged-in' );
			return;
		}

		$url = urldecode( $this->getVal( 'url', '' ) );
		if ( empty( $url ) ) {
			$this->error = wfMsg( 'videos-error-no-video-url' );
			return;
		}

		if ( $this->wg->User->isBlocked() ) {
			$this->error = wfMsg( 'videos-error-blocked-user' );
			return;
		}

		if ( wfReadOnly() ) {
			$this->error = wfMsg ( 'videos-error-readonly' );
			return;
		}

		$videoService = new VideoService();
		$retval = $videoService->addVideo( $url );

		if ( !is_array($retval) ) {
			$this->error = $retval;
		} else {
			$this->videoInfo = $retval;
		}
	}

}