<?php
class WikiaInteractiveMapsParserTagController extends WikiaController {

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
		if( !$this->validateParseTagParams( $args ) ) {
			return $this->sendRequest(
				'WikiaInteractiveMapsParserTagController',
				'parserTagError',
				$args
			);
		} else {
			return $this->sendRequest(
				'WikiaInteractiveMapsParserTagController',
				'mapThumbnail',
				$args
			);
		}
	}

	/**
	 * @desc Displays parser tag error
	 *
	 * @return string
	 */
	public function parserTagError() {
		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );
		$this->setVal(
			'errorMessage',
			wfMessage( 'wikia-interactive-maps-parser-tag-error', 'Error' )
		);
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
		$this->setVal( 'map', $map );

		$params = new stdClass();
		$params->lat = $this->getVal( 'lat' );
		$params->long = $this->getVal( 'long' );
		$params->zoom = $this->getVal( 'zoom' );
		$params->width = $this->getVal( 'width' );
		$params->height = $this->getVal( 'height' );
		$this->setVal( 'params', $params );

		$this->setVal( 'mapPageUrl', '#' );

		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );
		return $this->response->toString();
	}

	private function validateParseTagParams( Array $params ) {
		return false;
	}

}
