<?php

class JWPlayerTagController extends WikiaController {

	const PARSER_TAG_NAME = 'jwplayer';

	const SCRIPT_SRC = 'http://static.apester.com/js/sdk/v2.0/apester-javascript-sdk.min.js';

	const DATA_MEDIA_ID_ATTR = 'data-media-id';
	const ELEMENT_ID_PREFIX = 'jwPlayerTag';
	const HEIGHT_ATTR = 'height';

	private $wikiaTagBuilderHelper;

	public function __construct() {
		parent::__construct();

		$this->wikiaTagBuilderHelper = new WikiaTagBuilderHelper();
	}

	public static function onParserFirstCallInit( Parser $parser ) {
		$parser->setHook( self::PARSER_TAG_NAME, [ new static(), 'renderTag' ] );

		return true;
	}

	public function renderTag( $input, array $args, Parser $parser, PPFrame $frame ): string {
		if ( !$this->validateArgs( $args ) ) {
			// ToDo change to jwplayer message
			return '<strong class="error">' . wfMessage( 'apester-tag-could-not-render' )->parse() . '</strong>';
		}

		$script = JSSnippets::addToStack( [

		] );

		return $script . Html::element( 'div', $this->getAttributes( $args ) );
	}

	private function validateArgs( $args ): bool {
		return array_key_exists( self::DATA_MEDIA_ID_ATTR, $args );
	}

	private function getAttributes( $args ): array {
		$mediaId = $args[self::DATA_MEDIA_ID_ATTR];

		$attributes = [
			'class' => 'jwplayer-container',
			self::DATA_MEDIA_ID_ATTR => $mediaId,
			'id' => self::ELEMENT_ID_PREFIX . $mediaId
		];

		return $attributes;
	}
}
