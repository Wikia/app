<?php
class FliteTagController extends WikiaController {
	const PARSER_TAG_NAME = 'flite';

	public static function onParserFirstCallInit( Parser $parser ) {
		$parser->setHook( self::PARSER_TAG_NAME, [ new static(), 'renderFliteAdUnit' ] );
		return true;
	}

	public function renderFliteAdUnit() {
		return 'FLITE AD UNIT PLACEHOLDER';
	}

}
