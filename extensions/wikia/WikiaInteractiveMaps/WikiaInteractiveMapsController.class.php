<?php

class WikiaInteractiveMapsController extends WikiaSpecialPageController{

	const MAPS_PER_PAGE = 10;

	public function __construct( $name = null, $restriction = 'editinterface', $listed = true, $function = false, $file = 'default', $includable = false ) {
		parent::__construct( 'InteractiveMaps', $restriction, $listed, $function, $file, $includable );
	}

	public function index() {
		$this->wg->SuppressPageHeader = true;

		$mapsModel = new WikiaMaps( $this->getIntMapServiceConfig() );
		$params = [
			'city_id' => $this->app->wg->CityId
		];

		$maps = $mapsModel->cachedRequest( 'getMapsFromApi', $params );

		$this->setVal( 'maps', $maps );
		$messages = [
			'wikia-interactive-maps-title' => wfMessage( 'wikia-interactive-maps-title' ),
			'wikia-interactive-maps-create-a-map' => wfMessage( 'wikia-interactive-maps-create-a-map' ),
			'wikia-interactive-maps-no-maps' => wfMessage( 'wikia-interactive-maps-no-maps' )
		];
		$this->setVal( 'messages', $messages );

		$this->response->addAsset( 'extensions/wikia/WikiaInteractiveMaps/css/WikiaInteractiveMaps.scss' );
		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );
	}

	/**
	 * Get API Service configuration
	 *
	 * @return array
	 */
	private function getIntMapServiceConfig() {
		// TODO: Move this to config once we have the api server deployed
		return [
			'protocol' => 'http',
			'hostname' => '10.10.10.242',
			'port' => '3000',
			'version' => 'v1'
		];
	}

}
