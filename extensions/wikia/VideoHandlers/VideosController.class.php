<?php

class VideosController extends WikiaController {

	/**
	 * add video
	 * @requestParam string url
	 * @responseParam string html
	 * @responseParam string error - error message
	 */
	public function addVideo() {
		if ( !$this->wg->User->isLoggedIn() ) {
			$this->error = $this->wf->Msg( 'videos-error-not-logged-in' );
			return;
		}

		$url = urldecode( $this->getVal( 'url', '' ) );
		if ( empty( $url ) ) {
			$this->error = $this->wf->Msg( 'videos-error-no-video-url' );
			return;
		}

		if ( $this->wg->User->isBlocked() ) {
			$this->error = $this->wf->Msg( 'videos-error-blocked-user' );
			return;
		}

		$videoService = F::build( 'VideoService' );
		$retval = $videoService->addVideo( $url );

		if ( !is_array($retval) ) {
			$this->error = $retval;
		}
	}
	
	// temporary video survey code bugid-68723
	public function videoSurvey() {
		// just returns html
	}

}
