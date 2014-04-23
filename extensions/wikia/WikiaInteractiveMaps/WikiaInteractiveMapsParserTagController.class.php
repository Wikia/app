<?php
class WikiaInteractiveMapsParserTagController extends WikiaController {

	const DEFAULT_ZOOM = 7;
	const DEFAULT_WIDTH = 700;
	const DEFAULT_HEIGHT = 200;

	/**
	 * @desc Name of the parser tag
	 */
	const PARSER_TAG_NAME = 'imap';

	/**
	 * @desc Parser hook: used to register parser tag in MW
	 *
	 * @param Parser $parser
	 * @return bool
	 */
	public static function parserTagInit( Parser $parser ) {
		$parser->setHook( self::PARSER_TAG_NAME, [ new static(), 'renderPlaceholder' ] );
		return true;
	}

	/**
	 * @desc Based on parser tag arguments validation parsers an error or placeholder
	 *
	 * @param String $input
	 * @param Array $args
	 * @param Parser $parser
	 * @param PPFrame $frame
	 *
	 * @return String
	 */
	public function renderPlaceholder( $input, Array $args, Parser $parser, PPFrame $frame ) {
		$params = $this->sanitizeMapPlaceholderParams( $args );
		$error = $this->validateParseTagParams( $params );

		if( !empty($error) ) {
			return $this->sendRequest(
				'WikiaInteractiveMapsParserTagController',
				'parserTagError',
				[ 'errorMessage' => $error ]
			);
		} else {
			return $this->sendRequest(
				'WikiaInteractiveMapsParserTagController',
				'mapThumbnail',
				$params
			);
		}
	}

	/**
	 * @desc Displays parser tag error
	 *
	 * @return string
	 */
	public function parserTagError() {
		$this->setVal( 'errorMessage', $this->getVal( 'errorMessage' ) );
		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );
	}

	/**
	 * @desc Renders interactive maps placeholder
	 *
	 * @return null|string
	 */
	public function mapThumbnail() {
		$mapsModel = new WikiaMaps( $this->wg->IntMapConfig );
		$map = $mapsModel->cachedRequest(
			'getMapByIdFromApi',
			[ 'id' => $this->getVal( 'map-id' ) ]
		);

		$this->setVal( 'map', (object) $map );
		$this->setVal( 'params', $this->getMapPlaceholderParams() );
		$this->setVal( 'mapPageUrl', '#' );

		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );
	}

	/**
	 * @desc Gets map placeholder params from request
	 *
	 * @return stdClass
	 */
	private function getMapPlaceholderParams() {
		$params = [];

		$params['lat'] = $this->request->getVal( 'lat', 0 );
		$params['long'] = $this->request->getVal( 'long', 0 );
		$params['zoom'] = $this->request->getInt( 'zoom', static::DEFAULT_ZOOM );
		$params['width'] = $this->request->getInt( 'width', static::DEFAULT_WIDTH );
		$params['height'] = $this->request->getInt( 'height', static::DEFAULT_HEIGHT );

		$params['width'] .= 'px';
		$params['height'] .= 'px';

		return (object) $params;
	}

	/**
	 * @desc Sanitizes given data
	 *
	 * @param Array $data
	 *
	 * @return Array
	 */
	public function sanitizeMapPlaceholderParams( $data ) {
		$result = [];
		$validParams = [ 'map-id', 'lat', 'long', 'zoom', 'width', 'height' ];

		foreach( $validParams as $param ) {
			if ( isset( $data[$param] ) ) {
				$result[$param] = $data[$param];
			}
		}

		return $result;
	}

	/**
	 * @desc Validates data provided in parser tag arguments, returns empty string if there is no error
	 *
	 * @param Array $params an array with parser tag arguments
	 * @return String
	 */
	private function validateParseTagParams( Array $params ) {
		$error = '';
		$mapId = isset( $params['map-id'] ) ? intval( $params['map-id'] ) : 0;

		if( $mapId <= 0 ) {
			$error = wfMessage( 'wikia-interactive-maps-parser-tag-error-invalid-map-id' )->escaped();
		}

		return $error;
	}

}
