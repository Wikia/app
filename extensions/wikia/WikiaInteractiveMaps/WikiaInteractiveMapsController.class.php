<?php
/**
 * Class WikiaInteractiveMapsController
 * @desc Special:WikiaInteractiveMaps controller
 */
class WikiaInteractiveMapsController extends WikiaSpecialPageController {

	const MAP_HEIGHT = 300;
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
		$this->wg->out->setHTMLTitle( wfMessage( 'wikia-interactive-maps-title' )->escaped() );

		$mapsModel = new WikiaMaps( $this->wg->IntMapConfig );
		$params = [
			'city_id' => $this->app->wg->CityId
		];

		$maps = $mapsModel->cachedRequest( 'getMapsFromApi', $params );

		// Add map size to maps
		array_walk( $maps, function( &$map ) {
			$map->map_width = self::MAP_WIDTH;
			$map->map_height = self::MAP_HEIGHT;
			$map->status = $this->getMapStatusText( $map->status );
		});

		$this->setVal( 'maps', $maps );
		$this->setVal( 'hasMaps', !empty( $maps ) );
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
	 * @desc Returns human message based on the tiles processing status in database
	 *
	 * @param Integer $status status of tiles processing for the map
	 *
	 * @return String
	 */
	public function getMapStatusText( $status ) {
		$message = '';

		switch( $status ) {
			case WikiaMaps::STATUS_DONE:
				$message = wfMessage( 'wikia-interactive-maps-map-status-done' )->plain();
				break;
			case WikiaMaps::STATUS_PROCESSING:
				$message = wfMessage( 'wikia-interactive-maps-map-status-processing' )->plain();
				break;
		}

		return $message;
	}

}
