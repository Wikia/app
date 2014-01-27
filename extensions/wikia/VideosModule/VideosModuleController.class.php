<?php

class VideosModuleController extends WikiaController {

	const VIDEO_LIMIT = 40;

	/**
	 * VideosModule page
	 *
	 */
	public function executeIndex() {

		wfProfileIn( __METHOD__ );

		$articleId = $this->request->getVal( 'articleId', 0 );
		$helper = new VideosModuleHelper();
		$suggestedVideos = $helper->getSuggestedVideos( $articleId );
		$suggestedVideosCount = $suggestedVideos['returnedVideoCount'];

		$this->videos = $suggestedVideos['items'];

		if ( $suggestedVideosCount <= self::VIDEO_LIMIT ) {
			global $wgCityId;
			$numVideosNeeded = self::VIDEO_LIMIT - $suggestedVideosCount;
			$categoryName = WikiFactory::getCategory( $wgCityId )->cat_name;
			$categoryTitle = Title::newFromText( $categoryName, NS_CATEGORY );
			$categoryVideos = $helper->getVideosByCategory( $categoryTitle, $numVideosNeeded );
			if ( $categoryVideos ) {
				shuffle( $categoryVideos );
				$this->videos[] = $categoryVideos;
			}
		}

		wfProfileOut( __METHOD__ );
	}
}