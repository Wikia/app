<?php

class VideosModuleController extends WikiaController {

	/**
	 * VideosModule page
	 * @requestParam int articleId
	 * @responseParam string $result [ok/error]
	 * @responseParam string $msg - result message
	 * @responseParam array $videos - list of videos
	 */
	public function executeIndex() {

		wfProfileIn( __METHOD__ );

		$articleId = $this->request->getVal( 'articleId', 0 );

		if ( !$articleId ) {
			$this->result = 'error';
			$this->msg = wfMessage( 'videosmodule-error-no-articleId' )->plain();
			wfProfileOut(__METHOD__);
			return;
		}

		$helper = new VideosModuleHelper();
		$this->videos = $helper->getVideos( $articleId  );
		$this->result = "ok";
		$this->msg = '';

		wfProfileOut( __METHOD__ );
	}
}