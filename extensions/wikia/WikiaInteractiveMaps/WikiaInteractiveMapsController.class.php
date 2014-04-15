<?php

class WikiaInteractiveMapsController extends WikiaSpecialPageController{

	public function __construct( $name = null, $restriction = 'editinterface', $listed = true, $function = false, $file = 'default', $includable = false ) {
		parent::__construct( 'InteractiveMaps', $restriction, $listed, $function, $file, $includable );
	}

	public function index() {
		$mapsModel = new WikiaMaps();
		$maps = $mapsModel->getMapInstances( $this->app->wg->CityId );
		$this->setVal( 'maps', $maps );

		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );
	}

} 