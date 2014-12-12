<?php

class VideosModuleController extends WikiaController {
	const DEFAULT_TEMPLATE_ENGINE = WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;
	const DEFAULT_REGION = 'US';

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
		$userRegion = $this->request->getVal( 'userRegion', self::DEFAULT_REGION );

		$staffModule = new VideosModule\Staff( $userRegion );
		$staffVideos = $staffModule->getVideos();

		if ( !empty( $this->wg->VideosModuleCategories )  ) {
			$module = new VideosModule\Category( $userRegion );
		} else {
			$module = new VideosModule\Related( $userRegion );
		}
		$videos = $module->getVideos();

		$this->response->setData( [
			'title'	 => wfMessage( 'videosmodule-title-default' )->escaped(),
			'videos' => $videos,
			'staffVideos' => $staffVideos
		] );

		// Set client cache
		$this->response->setCacheValidity( VideosModule\Base::CACHE_TTL );
	}

	public function clear() {
		$userRegion = $this->request->getVal( 'userRegion', VideosModule\Base::DEFAULT_REGION );

		$staffModule = new VideosModule\Staff( $userRegion );
		$staffModule->clearCache();

		if ( !empty( $this->wg->VideosModuleCategories )  ) {
			$module = new VideosModule\Category( $userRegion );
		} else {
			$module = new VideosModule\Related( $userRegion );
		}
		$module->clearCache();

		$this->response->setData([
			'result' => 'ok',
			'msg' => '',
		]);
	}
}
