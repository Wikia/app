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
		$validParams = [
			'map-id' => 'id',
			'lat' => 'lat',
			'long' => 'long',
			'zoom' => 'zoom',
			'width' => 'width',
			'height' => 'height',
		];

		foreach( $validParams as $key => $mapTo ) {
			if ( isset( $data[$key] ) ) {
				$result[$mapTo] = $data[$key];
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

		$mapId = isset( $params['id'] ) ? intval( $params['id'] ) : 0;
		if( $mapId <= 0 ) {
			$error = wfMessage( 'wikia-interactive-maps-parser-tag-error-invalid-map-id' )->escaped();
		}

		$lat = isset( $params['lat'] ) ? $params['lat'] : null;
		if( !is_null( $lat ) && !is_numeric( $lat ) ) {
			$error = wfMessage( 'wikia-interactive-maps-parser-tag-error-invalid-latitude' )->escaped();
		}

		$long = isset( $params['long'] ) ? $params['long'] : null;
		if( !is_null( $long ) && !is_numeric( $long ) ) {
			$error = wfMessage( 'wikia-interactive-maps-parser-tag-error-invalid-longitude' )->escaped();
		}

		$zoom = isset( $params['zoom'] ) ? intval( $params['zoom'] ) : null;
		if( !is_null( $zoom ) && $zoom < 0 ) {
			$error = wfMessage( 'wikia-interactive-maps-parser-tag-error-invalid-zoom' )->escaped();
		}

		$width = isset( $params['width'] ) ? intval( $params['width'] ) : null;
		if( !is_null( $width ) && $width <= 0 ) {
			$error = wfMessage( 'wikia-interactive-maps-parser-tag-error-invalid-width' )->escaped();
		}

		$height = isset( $params['height'] ) ? intval( $params['height'] ) : null;
		if( !is_null( $height ) && $height <= 0 ) {
			$error = wfMessage( 'wikia-interactive-maps-parser-tag-error-invalid-height' )->escaped();
		}

		return $error;
	}

}
