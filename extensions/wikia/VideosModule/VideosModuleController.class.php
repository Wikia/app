<?php

class VideosModuleController extends WikiaController {

	const VIDEO_LIMIT = 20;

	/**
	 * VideosModule page
	 *
	 */
	public function executeIndex() {
		$articleId = $this->request->getVal( 'articleId', 0 );
		$helper = new VideosModuleHelper();
		$suggestedVideos = $helper->getSuggestedVideos( $articleId );

		$this->videos = $suggestedVideos['items'];

		if ( $suggestedVideos['totalSuggestedVideos'] <= self::VIDEO_LIMIT ) {
			global $wgCityId;
			$category = WikiFactory::getCategory( $wgCityId );
		}

		$this->category = $category;

		$this->hello_world = "Hello world!";
	}
}