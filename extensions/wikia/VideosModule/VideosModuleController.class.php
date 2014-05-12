<?php

class VideosModuleController extends WikiaController {

	const VIDEOS_PER_PAGE = 20;

	/**
	 * VideosModule
	 * Returns videos to populate the Videos Module. First try and get premium videos
	 * related to the article page. If that's not enough add premium videos related
	 * to the local wiki. Finally, if still more or needed, get trending premium
	 * videos related to the vertical of the wiki.
	 * @requestParam integer limit - number of videos shown in the module
	 * @responseParam string $result [ok/error]
	 * @responseParam string $msg - result message
	 * @responseParam array $videos - list of videos
	 * @responseParam array $staffVideos - list of staff picked videos
	 */
	public function index() {
		wfProfileIn( __METHOD__ );

		$this->title = wfMessage( 'videosmodule-title-default' )->plain();
		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );
		$this->response->getView()->setTemplatePath( dirname(__FILE__) . '/templates/mustache/rail.mustache' );
		$numRequired = $this->request->getVal( 'limit', self::VIDEOS_PER_PAGE );

		$module = new VideosModule();
		$this->result = "ok";
		$this->msg = '';
		$this->videos = $module->getWikiRelatedVideosTopics( $numRequired );
		$this->staffVideos = $module->getStaffPicks();

		// set cache
		$this->response->setCacheValidity( 600 );

		wfProfileOut( __METHOD__ );
	}

}
