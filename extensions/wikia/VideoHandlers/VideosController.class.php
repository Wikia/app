<?php

class VideosController extends WikiaController {

	public function getAddVideoModal() {
		$pgTitle = $this->request->getVal( 'title', '' );
		$supressSuggestions = $this->request->getVal( 'supressSuggestions', false );

		$html = $this->app->renderView( 'Videos', 'addVideoModalText', array('pageTitle'=>$pgTitle, 'supressSuggestions' => $supressSuggestions) );

		$this->setVal( 'pageTitle', $pgTitle );
		$this->setVal( 'html', $html );
		$this->setVal( 'title',	$this->wf->Msg('videos-add-video-to-this-wiki') );
	}

	public function addVideoModalText() {
		$this->setVal( 'supressSuggestions', $this->request->getVal('supressSuggestions', false) );
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
		$url = urldecode( $this->getVal( 'url', '' ) );

		if ( !$this->wg->User->isLoggedIn() ) {
			$this->error = $this->wg->Msg( 'videos-error-not-logged-in' );
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
