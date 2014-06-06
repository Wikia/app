<?php

class VideosModuleController extends WikiaController {
	const DEFAULT_TEMPLATE_ENGINE = WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;

	/**
	 * VideosModule
	 * Returns videos to populate the Videos Module. First try and get premium videos
	 * related to the article page. If that's not enough add premium videos related
	 * to the local wiki. Finally, if still more or needed, get trending premium
	 * videos related to the vertical of the wiki.
	 * @requestParam integer limit - number of videos shown in the module
	 * @requestParam string local [true/false] - show local content
	 * @requestParam string sort [recent/trend] - how to sort the results
	 * @responseParam string $result [ok/error]
	 * @responseParam string $msg - result message
	 * @responseParam array $videos - list of videos
	 * @responseParam array $staffVideos - list of staff picked videos
	 */
	public function index() {
		wfProfileIn( __METHOD__ );

		$this->title = wfMessage( 'videosmodule-title-default' )->plain();
		$numRequired = $this->request->getVal( 'limit', VideosModule::LIMIT_VIDEOS );
		$localContent = ( $this->request->getVal( 'local' ) == 'true' );
		$sort = $this->request->getVal( 'sort', 'trend' );

		$module = new VideosModule();
		if ( $localContent ) {
			$videos = $module->getLocalVideos( $numRequired, $sort );
		} else {
			$videos = $module->getVideosByCategory();
			if ( empty( $videos ) ) {
				$videos = $module->getWikiRelatedVideosTopics( $numRequired );
			}
		}

		$this->result = "ok";
		$this->msg = '';
		$this->videos = $videos;
		$this->staffVideos = $module->getStaffPicks();

		// set cache
		$this->response->setCacheValidity( 600 );

		wfProfileOut( __METHOD__ );
	}

}
