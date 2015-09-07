<?php
class FliteTagController extends WikiaController {
	const PARSER_TAG_NAME = 'flite';

	public static function onParserFirstCallInit( Parser $parser ) {
		$parser->setHook( self::PARSER_TAG_NAME, [ new static(), 'renderFliteAdUnit' ] );
		return true;
	}

	public function renderFliteAdUnit( $input, array $args, Parser $parser, PPFrame $frame ) {
		return $this->sendRequest(
			'FliteTagController',
			'fliteAdUnit',
			[
				'guid' => $args['guid'],
				'width' => $args['width'],
				'height' => $args['height'],
			]
		);
	}

	public function fliteAdUnit() {
		$this->setVal('guid', $this->getVal('guid'));
		$this->setVal('width', $this->getVal('width'));
		$this->setVal('height', $this->getVal('height'));

		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );
	}

}
