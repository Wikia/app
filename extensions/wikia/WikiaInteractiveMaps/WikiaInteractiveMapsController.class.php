<?php

class WikiaInteractiveMapsController extends WikiaSpecialPageController{
	/**
	 * Name of the parser tag
	 */
	const PARSER_TAG_NAME = 'imap';

	/**
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

	/**
	 * @desc Parser hook: used to register parser tag in MW
	 *
	 * @param Parser $parser
	 * @return bool
	 */
	public static function parserTagInit( Parser $parser ) {
		$parser->setHook( self::PARSER_TAG_NAME, [ new self(), 'renderPlaceholder' ] );
		return true;
	}

	/**
	 * @desc Renders interactive map thumbnail in place of interactive map parser tag in the article content
	 *
	 * @param String $input
	 * @param Array $args
	 * @param Parser $parser
	 * @param PPFrame $frame
	 *
	 * @return String
	 */
	public function renderPlaceholder( $input, Array $args, Parser $parser, PPFrame $frame ) {
		return 'Wikia Interactive Map placeholder';
	}

}
