<?php

class WikiaInteractiveMapsController extends WikiaSpecialPageController{

	const MAPS_PER_PAGE = 10;

	public function __construct( $name = null, $restriction = 'editinterface', $listed = true, $function = false, $file = 'default', $includable = false ) {
		parent::__construct( 'InteractiveMaps', $restriction, $listed, $function, $file, $includable );
	}

	public function index() {
		$mapsModel = new WikiaMaps( $this->getIntMapServiceConfig() );
		$search = $this->request->getVal('search_maps', false);
		$mapOrder = $this->request->getInt('map_order', false);
		$offset = $this->request->getVal('offset', false);


		$maps = $mapsModel->getMapInstances(
			$this->app->wg->CityId,
			$search,
			$mapOrder,
			$offset,
			self::MAPS_PER_PAGE
		);
		$this->setVal( 'maps', $maps );

		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );
	}

	private function getIntMapServiceConfig() {
		return [];
	}

}
