<?php
class WikiaInteractiveMapsParserTagController extends WikiaController {

	//TODO: figure out max and min height and width - PO design decision
	const DEFAULT_ZOOM = 7;
	const MIN_ZOOM = 0;
	const DEFAULT_WIDTH = 700;
	const MAX_WIDTH = 1270;
	const MIN_WIDTH = 100;
	const DEFAULT_HEIGHT = 200;
	const MAX_HEIGHT = 500;
	const MIN_HEIGHT = 50;
	const DEFAULT_LATITUDE = 0;
	const DEFAULT_LONGITUDE = 0;
	const PARSER_TAG_NAME = 'imap';
	const RENDER_ENTRY_POINT = 'render';

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
		$errorMessage = '';
		$params = $this->sanitizeParserTagArguments( $args );
		$isValid = $this->validateParseTagParams( $params, $errorMessage );

		if( $isValid ) {
			$params[ 'map' ] = $this->getMapObj( $params[ 'id' ] );

			if ( !empty( $params [ 'map' ] ) ) {
				return $this->sendRequest(
					'WikiaInteractiveMapsParserTagController',
					'mapThumbnail',
					$params
				);
			} else {
				$errorMessage = wfMessage( 'wikia-interactive-maps-parser-tag-error-no-map-found' )->plain();
			}
		}

		return $this->sendRequest(
			'WikiaInteractiveMapsParserTagController',
			'parserTagError',
			[ 'errorMessage' => $errorMessage ]
		);
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
		$params = $this->getMapPlaceholderParams();
		$mapsModel = new WikiaMaps( $this->wg->IntMapConfig );

		$params->map->url = $mapsModel->buildUrl([
			WikiaMaps::ENTRY_POINT_RENDER,
			$params->map->id,
			$params->zoom,
			$params->lat,
			$params->lon,
		]);

		$this->setVal( 'map', (object) $params->map );
		$this->setVal( 'params', $params );

		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );
	}

	/**
	 * @desc Get map object from API
	 *
	 * @param integer $mapId - map object id
	 *
	 * @return object - map object
	 */
	private function getMapObj( $mapId ) {
		$mapsModel = new WikiaMaps( $this->wg->IntMapConfig );

		return $mapsModel->cachedRequest(
			'getMapByIdFromApi',
			[ 'id' => $mapId ]
		);
	}

	/**
	 * @desc Gets map placeholder params from request
	 *
	 * @return stdClass
	 */
	private function getMapPlaceholderParams() {
		$params = [];

		$params[ 'lat' ] = $this->request->getVal( 'lat', static::DEFAULT_LATITUDE );
		$params[ 'lon' ] = $this->request->getVal( 'lon', static::DEFAULT_LONGITUDE );
		$params[ 'zoom' ] = $this->request->getInt( 'zoom', static::DEFAULT_ZOOM );
		$params[ 'width' ] = $this->request->getInt( 'width', static::DEFAULT_WIDTH );
		$params[ 'height' ] = $this->request->getInt( 'height', static::DEFAULT_HEIGHT );
		$params[ 'map' ] = $this->request->getVal( 'map' );

		$params[ 'width' ] .= 'px';
		$params[ 'height' ] .= 'px';

		return (object) $params;
	}

	/**
	 * @desc Sanitizes given data
	 *
	 * @param Array $data
	 *
	 * @return Array
	 */
	public function sanitizeParserTagArguments( $data ) {
		$result = [];
		$validParams = [
			'map-id' => 'id',
			'lat' => 'lat',
			'lon' => 'lon',
			'zoom' => 'zoom',
			'width' => 'width',
			'height' => 'height',
		];

		foreach( $validParams as $key => $mapTo ) {
			if ( !empty( $data[ $key ] ) ) {
				$result[ $mapTo ] = $data[ $key ];
			}
		}

		return $result;
	}

	/**
	 * @desc Validates data provided in parser tag arguments, returns empty string if there is no error
	 *
	 * @param Array $params an array with parser tag arguments
	 * @param String $errorMessage a variable where the error message will be assigned to
	 *
	 * @return String
	 */
	public function validateParseTagParams( Array $params, &$errorMessage ) {
		$isValid = false;

		if( empty( $params ) ) {
			$errorMessage = wfMessage( 'wikia-interactive-maps-parser-tag-error-no-require-parameters' )->plain();
			return $isValid;
		}

		foreach( $params as $param => $value ) {
			$isValid = $this->isTagParamValid( $param, $value, $errorMessage );

			if( !$isValid ) {
				return $isValid;
			}
		}

		return $isValid;
	}

	/**
	 * @desc Checks if parameter from parameters array is valid
	 *
	 * @param String $paramName name of parameter which should get validated
	 * @param String|Mixed $paramValue value of the parameter
	 * @param String $errorMessage reference to a string variable which will get error message if one occurs
	 *
	 * @return bool
	 */
	private function isTagParamValid( $paramName, $paramValue, &$errorMessage ) {
		$isValid = false;

		$validator = $this->buildParamValidator( $paramName );
		if( $validator ) {
			$isValid = $validator->isValid( $paramValue );

			if( !$isValid ) {
				$errorMessage = $validator->getError()->getMsg();
			}
		}

		return $isValid;
	}

	/**
	 * @desc Small factory method to create validators for params; returns false if validator can't be created
	 *
	 * @param String $paramName
	 * @return bool|WikiaValidator
	 */
	private function buildParamValidator( $paramName ) {
		$validator = false;

		switch( $paramName ) {
			case 'id':
				$validator = new WikiaValidatorInteger(
					[ 'required' => true ],
					[ 'not_int' => 'wikia-interactive-maps-parser-tag-error-invalid-map-id' ]
				);
				break;
			case 'lat':
				$validator = new WikiaValidatorNumeric(
					[],
					[ 'not_numeric' => 'wikia-interactive-maps-parser-tag-error-invalid-latitude' ]
				);
				break;
			case 'lon':
				$validator = new WikiaValidatorNumeric(
					[],
					[ 'not_numeric' => 'wikia-interactive-maps-parser-tag-error-invalid-longitude' ]
				);
				break;
			case 'zoom':
				$validator = new WikiaValidatorInteger(
					[ 'min' => static::MIN_ZOOM ],
					[ 'not_int' => 'wikia-interactive-maps-parser-tag-error-invalid-zoom' ]
				);
				break;
			case 'width':
				$validator = new WikiaValidatorInteger(
					[
						'min' => static::MIN_WIDTH,
						'max' => static::MAX_WIDTH
					],
					[
						'not_int' => 'wikia-interactive-maps-parser-tag-error-invalid-width',
						//TODO: we should be able to pass const MIN and MAX values to the message
						'too_small' => 'wikia-interactive-maps-parser-tag-error-invalid-width',
						'too_big' => 'wikia-interactive-maps-parser-tag-error-invalid-width'
					]
				);
				break;
			case 'height':
				$validator = new WikiaValidatorInteger(
					[
						'min' => static::MIN_HEIGHT,
						'max' => static::MAX_HEIGHT
					],
					[
						'not_int' => 'wikia-interactive-maps-parser-tag-error-invalid-height',
						//TODO: we should be able to pass const MIN and MAX values to the message
						'too_small' => 'wikia-interactive-maps-parser-tag-error-invalid-width',
						'too_big' => 'wikia-interactive-maps-parser-tag-error-invalid-width'
					]
				);
				break;
		}

		return $validator;
	}

}
