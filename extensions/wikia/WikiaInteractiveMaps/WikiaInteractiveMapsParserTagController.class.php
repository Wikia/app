<?php
class WikiaInteractiveMapsParserTagController extends WikiaController {

	const DEFAULT_ZOOM = 7;
	const DEFAULT_WIDTH = 700;
	const DEFAULT_HEIGHT = 200;
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
		$errorMessage = '';
		$params = $this->sanitizeMapPlaceholderParams( $args );
		$isValid = $this->validateParseTagParams( $params, $errorMessage );

		if( !$isValid ) {
			return $this->sendRequest(
				'WikiaInteractiveMapsParserTagController',
				'parserTagError',
				[ 'errorMessage' => $errorMessage ]
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
			[ 'id' => $this->getVal( 'id' ) ]
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

		$params[ 'lat' ] = $this->request->getVal( 'lat', 0 );
		$params[ 'long' ] = $this->request->getVal( 'long', 0 );
		$params[ 'zoom' ] = $this->request->getInt( 'zoom', static::DEFAULT_ZOOM );
		$params[ 'width' ] = $this->request->getInt( 'width', static::DEFAULT_WIDTH );
		$params[ 'height' ] = $this->request->getInt( 'height', static::DEFAULT_HEIGHT );

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
			if ( isset( $data[ $key ] ) ) {
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
			$errorMessage = wfMessage( 'wikia-interactive-maps-parser-tag-error-no-require-parameters' )->escaped();
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
			case 'long':
				$validator = new WikiaValidatorNumeric(
					[],
					[ 'not_numeric' => 'wikia-interactive-maps-parser-tag-error-invalid-longitude' ]
				);
				break;
			case 'zoom':
				$validator = new WikiaValidatorInteger(
					[ 'min' => 0 ],
					[ 'not_int' => 'wikia-interactive-maps-parser-tag-error-invalid-zoom' ]
				);
				break;
			case 'width':
				$validator = new WikiaValidatorInteger(
					[ 'min' => 1 ],
					[ 'not_int' => 'wikia-interactive-maps-parser-tag-error-invalid-width' ]
				);
				break;
			case 'height':
				$validator = new WikiaValidatorInteger(
					[ 'min' => 1 ],
					[ 'not_int' => 'wikia-interactive-maps-parser-tag-error-invalid-height' ]
				);
				break;
		}

		return $validator;
	}

}
