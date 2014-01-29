<?php

class VideosModuleController extends WikiaController {

	/**
	 * VideosModule page
	 */
	public function executeIndex() {

		wfProfileIn( __METHOD__ );

		$articleId = $this->request->getVal( 'articleId', 0 );

		if ( !$articleId ) {
			wfProfileOut(__METHOD__);
			throw new Exception( "Please include the articleID." );
		}

		$helper = new VideosModuleHelper();
		$this->videos = $helper->getVideos( $articleId  );

		wfProfileOut( __METHOD__ );
	}
}