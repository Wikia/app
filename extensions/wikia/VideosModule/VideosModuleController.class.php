<?php

class VideosModuleController extends WikiaController {

	/**
	 * VideosModule
	 * Returns videos to populate the Videos Module. First try and get premium videos
	 * related to the article page. If that's not enough add premium videos related
	 * to the local wiki. Finally, if still more or needed, get trending premium
	 * videos related to the vertical of the wiki.
	 * @requestParam integer articleId
	 * @requestParam integer verticalonly [0/1] - show vertical videos only
	 * @responseParam string $result [ok/error]
	 * @responseParam string $msg - result message
	 * @responseParam array $videos - list of videos
	 */
	public function executeIndex() {
		wfProfileIn( __METHOD__ );

		$articleId = $this->request->getVal( 'articleId', 0 );
		$showVerticalOnly = $this->request->getVal( 'verticalonly', 0 );

		$videos = [];
		$helper = new VideosModuleHelper();

		if ( empty( $showVerticalOnly ) ) {
			if ( empty( $articleId ) ) {
				$this->result = 'error';
				$this->msg = wfMessage( 'videosmodule-error-no-articleId' )->plain();
				wfProfileOut( __METHOD__ );
				return;
			}

			// get article related videos
			$videos = $helper->getArticleRelatedVideos( $articleId );

			// Add videos from getWikiRelatedVideos if we didn't hit our video count limit
			if ( count( $videos ) < VideosModuleHelper::VIDEO_LIMIT ) {
				$videos = $helper->getWikiRelatedVideos( $videos );
			}

		}

		if ( count( $videos ) < VideosModuleHelper::VIDEO_LIMIT ) {
			// get vertical videos
			$videos = $helper->getVerticalVideos( $videos );
		}

		$this->result = "ok";
		$this->msg = '';
		$this->videos = $videos;

		wfProfileOut( __METHOD__ );
	}

}