<?php

class ApesterTagController extends WikiaController {

	const PARSER_TAG_NAME = 'apester';

	const SCRIPT_SRC = 'https://static.apester.com/js/sdk/v2.0/apester-javascript-sdk.min.js';

	const DATA_MEDIA_ID_ATTR = 'data-media-id';
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
			return '<strong class="error">' . wfMessage( 'apester-tag-could-not-render' )->parse() . '</strong>';
		}

		$script = JSSnippets::addToStack( self::SCRIPT_SRC );

		return $script . Html::element( 'div', $this->getAttributes( $args ) );
	}

	private function validateArgs( $args ): bool {
		return array_key_exists( self::DATA_MEDIA_ID_ATTR, $args );
	}

	private function getAttributes( $args ): array {
		$attributes = [
			'class' => 'apester-media',
			self::DATA_MEDIA_ID_ATTR => $args[self::DATA_MEDIA_ID_ATTR],
			self::HEIGHT_ATTR => $args[self::HEIGHT_ATTR] ?? '540'
		];

		if ( $this->wikiaTagBuilderHelper->isMobileSkin() ) {
			$attributes['data-wikia-widget'] = self::PARSER_TAG_NAME;
		}

		return $attributes;
	}
}
