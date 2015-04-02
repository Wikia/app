<?php
class PortableInfoboxParserTagController extends WikiaController {
	const PARSER_TAG_NAME = 'infobox';

	/**
	 * @desc Parser hook: used to register parser tag in MW
	 *
	 * @param Parser $parser
	 * @return bool
	 */
	public static function parserTagInit( Parser $parser ) {
		$parser->setHook( self::PARSER_TAG_NAME, [new static(), 'renderInfobox'] );
		return true;
	}

	public function renderInfobox() {}
}
