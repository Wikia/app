<?php

class VideosModuleController extends WikiaController {

	/**
	 * VideosModule
	 * Returns videos to populate the Videos Module. First try and get premium videos
	 * related to the article page. If that's not enough add premium videos related
	 * to the local wiki. Finally, if still more or needed, get trending premium
	 * videos related to the vertical of the wiki.
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
		$articleRelatedVideos = $helper->getArticleRelatedVideos( $articleId );
		$articleRelatedVideosCount = $articleRelatedVideos['returnedVideoCount'];
		$videos = $articleRelatedVideos['items'];

		// Add videos from getWikiRelatedVideos if we didn't hit our video count limit
		if ( $articleRelatedVideosCount < $helper::VIDEO_LIMIT ) {
			$wikiRelatedVideos = $helper->getWikiRelatedVideos();
			array_splice( $wikiRelatedVideos, $helper::VIDEO_LIMIT - $articleRelatedVideosCount );
			// We want these to always be shown in a random order to the user
			shuffle( $wikiRelatedVideos );
			$videos = array_merge( $videos,  $wikiRelatedVideos );
		}

		$this->result = "ok";
		$this->msg = '';
		$this->videos = $videos;

		wfProfileOut( __METHOD__ );
	}
}