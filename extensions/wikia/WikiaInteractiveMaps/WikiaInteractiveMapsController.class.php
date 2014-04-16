<?php

class WikiaInteractiveMapsController extends WikiaSpecialPageController{

	const MAPS_PER_PAGE = 10;

	public function __construct( $name = null, $restriction = 'editinterface', $listed = true, $function = false, $file = 'default', $includable = false ) {
		parent::__construct( 'InteractiveMaps', $restriction, $listed, $function, $file, $includable );
	}

	public function index() {
		$mapsModel = new WikiaMaps( $this->getIntMapServiceConfig() );
		$params = [
			'city_id' => $this->app->wg->CityId
		];

		$maps = $mapsModel->cachedRequest( 'getMapInstances', $params );

		$this->setVal( 'maps', $maps );
		$this->setVal( 'wikia-interactive-maps-title', wfMessage( 'wikia-interactive-maps-title' ) );
		$this->setVal( 'wikia-interactive-maps-create-a-map', wfMessage( 'wikia-interactive-maps-create-a-map' ) );

		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );
	}

	private function getIntMapServiceConfig() {
		return [
			'protocol' => 'http',
			'hostname' => '10.10.10.242',
			'port' => '3000',
			'version' => 'v1'
		];
	}

}
