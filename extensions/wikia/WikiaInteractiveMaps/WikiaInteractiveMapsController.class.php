<?php

class WikiaInteractiveMapsController extends WikiaSpecialPageController{

	/*
	 * Map image height
	 */
	const MAP_HEIGHT = 300;

	/**
	 * Map image width
	 */
	const MAP_WIDTH = 1600;

	/**
	 * @desc Special page constructor
	 *
	 * @param null $name
	 * @param string $restriction
	 * @param bool $listed
	 * @param bool $function
	 * @param string $file
	 * @param bool $includable
	 */
	public function __construct( $name = null, $restriction = 'editinterface', $listed = true, $function = false, $file = 'default', $includable = false ) {
		parent::__construct( 'InteractiveMaps', $restriction, $listed, $function, $file, $includable );
	}

	/**
	 * Interactive maps special page
	 */
	public function index() {
		$this->wg->SuppressPageHeader = true;

		$mapsModel = new WikiaMaps( $this->wg->IntMapConfig );
		$params = [
			'city_id' => $this->app->wg->CityId
		];

		$maps = $mapsModel->cachedRequest( 'getMapsFromApi', $params );

		// Add map size to maps
		array_walk( $maps, function( &$map ) {
			$map[ 'map_width' ] = self::MAP_WIDTH;
			$map[ 'map_height' ] = self::MAP_HEIGHT;
		});

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
}
