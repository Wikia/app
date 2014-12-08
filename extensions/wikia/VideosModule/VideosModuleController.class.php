<?php

class VideosModuleController extends WikiaController {
	const DEFAULT_TEMPLATE_ENGINE = WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;

	/**
	 * VideosModule
	 * Returns videos to populate the Videos Module. First check if
	 * local videos are being requested from the front-end (this is not
	 * yet in use but will be used for A/B testing down the line). If not,
	 * check if there are categories associated with this wiki for the
	 * Videos Module and pull premium videos from those categories. Finally, if
	 * neither of those first conditions are true, search for premium
	 * videos related to the wiki.
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

		$userRegion = $this->request->getVal( 'userRegion', VideosModule::DEFAULT_REGION );
		$module = new VideosModule( $userRegion );
		$staffVideos = $module->getStaffPicks();
		if ( !empty( $this->wg->VideosModuleCategories )  ) {
			$videos = $module->getVideosByCategory();
		} else {
			$videos = $module->getVideosRelatedToWiki();
		}

		$this->response->setData( [
			'title'	 => wfMessage( 'videosmodule-title-default' )->plain(),
			'videos' => $videos,
			'staffVideos' => $staffVideos
		] );

		// set cache
		$this->response->setCacheValidity( VideosModule::CACHE_TTL );

		wfProfileOut( __METHOD__ );
	}

}
