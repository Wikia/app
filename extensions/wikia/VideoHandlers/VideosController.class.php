<?php

class VideosController extends WikiaController {

	public function getAddVideoModal() {
		$pgTitle = $this->request->getVal( 'title', '' );
		$suppressSuggestions = $this->request->getVal( 'suppressSuggestions', true );

		$html = $this->app->renderView( 'Videos', 'addVideoModalText', array('pageTitle'=>$pgTitle, 'suppressSuggestions' => $suppressSuggestions) );

		$this->setVal( 'pageTitle', $pgTitle );
		$this->setVal( 'html', $html );
		$this->setVal( 'title',	$this->wf->Msg('videos-add-video-to-this-wiki') );
	}

	public function addVideoModalText() {
		$this->setVal( 'suppressSuggestions', $this->request->getVal('suppressSuggestions', true) );
		$this->setVal( 'pageTitle', $this->request->getVal('pageTitle', '') );
	}

	/**
	 * add video
	 * @requestParam integer articleId
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

		if ( is_array($retval) ) {
			$this->html = '<div></div>';
			$this->error = null;
		} else {
			$this->html = null;
			$this->error = $retval;
		}
	}

}
