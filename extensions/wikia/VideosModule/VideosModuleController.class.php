<?php

class VideosModuleController extends WikiaController {

	const VIDEOS_PER_PAGE = 8;

	/**
	 * VideosModule
	 * Returns videos to populate the Videos Module. First try and get premium videos
	 * related to the article page. If that's not enough add premium videos related
	 * to the local wiki. Finally, if still more or needed, get trending premium
	 * videos related to the vertical of the wiki.
	 * @requestParam integer articleId (required if verticalOnly is false)
	 * @requestParam integer limit - number of videos shown in the module
	 * @requestParam string verticalOnly [true/false] - show vertical videos only
	 * @requestParam string local [true/false] - show local content
	 * @requestParam string sort [recent/trend] - how to sort the results
	 * @responseParam string $result [ok/error]
	 * @responseParam string $msg - result message
	 * @responseParam array $videos - list of videos
	 */
	public function index() {
		wfProfileIn( __METHOD__ );

		$this->title = wfMessage( 'videosmodule-title-default' )->plain();
		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );
		$this->response->getView()->setTemplatePath( dirname(__FILE__) . '/templates/mustache/rail.mustache' );

		$articleId = $this->request->getVal( 'articleId', 0 );
		$showVerticalOnly = ( $this->request->getVal( 'verticalOnly' ) == 'true' );
		$numRequired = $this->request->getVal( 'limit', self::VIDEOS_PER_PAGE );
		$localContent = ( $this->request->getVal( 'local' ) == 'true' );
		$sort = $this->request->getVal( 'sort', 'trend' );

		$videos = [];
		$module = new VideosModule();

		if ( $localContent ) {
			$videos = $module->getLocalVideos( $numRequired, $sort );
		} else {
			if ( !$showVerticalOnly ) {
				if ( empty( $articleId ) ) {
					$this->result = 'error';
					$this->msg = wfMessage( 'videosmodule-error-no-articleId' )->plain();
					$this->videos = [];
					wfProfileOut( __METHOD__ );
					return;
				}

				// get related videos (article related videos and wiki related videos)
				$videos = $module->getRelatedVideos( $articleId, $numRequired );
			}

			// get vertical videos
			$numRequired = $numRequired - count( $videos );
			if ( $numRequired > 0 ) {
				$videos = array_merge( $videos, $module->getVerticalVideos( $numRequired, $sort ) );
			}
		}

		$this->result = "ok";
		$this->msg = '';
		$this->videos = $videos;

		// set cache
		$this->response->setCacheValidity( 600 );

		wfProfileOut( __METHOD__ );
	}

}
