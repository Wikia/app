<?php

class VideosModuleController extends WikiaController {
	const DEFAULT_TEMPLATE_ENGINE = WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;

	/**
	 * VideosModule
	 * Returns videos to populate the Videos Module. First check if there are
	 * categories associated with this wiki for the Videos Module and pull
	 * premium videos from those categories. Finally, if neither of those
	 * first conditions are true, search for premium videos related to the wiki.
	 * @responseParam string $title - i18nized title of the videos module
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
			'title'	 => wfMessage( 'videosmodule-title-default' )->escaped(),
			'videos' => $videos,
			'staffVideos' => $staffVideos
		] );

		// set cache
		$this->response->setCacheValidity( VideosModule::CACHE_TTL );

		wfProfileOut( __METHOD__ );
	}

	public function test() {
		$helper = new UserLoginHelper();
		$helper->sendConfirmationEmail( "james_test_en" );
	}

}
