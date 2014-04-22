<?php
class WikiaInteractiveMapsParserTagController extends WikiaController {

	/**
	 * Name of the parser tag
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
			return $this->getParserTagError();
		} else {
			return $this->getMapThumbnail();
		}
	}

	public function getParserTagError() {
		return 'WIKIA INTERACTIVE MAPS PLACEHOLDER ERROR OCCURRED';
	}

	public function getMapThumbnail() {
		return 'WIKIA INTERACTIVE MAPS PLACEHOLDER';
	}

	private function validateParseTagParams( Array $params ) {
		return true;
	}

}
