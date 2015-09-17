<?php

class VKTagController extends WikiaController {

	const PARSER_TAG_NAME = 'vk';

	const TAG_ALLOWED_ATTRIBUTES = [
		'group-id',
		'width',
		'height',
		'mode',
		'wide',
		'color1',
		'color2',
		'color3',
	];

	const TAG_DEFAULT_ATTRIBUTES = [
		'data-wikia-widget' => self::PARSER_TAG_NAME,
	];

	private $tagBuilderHelper;
	private $validator;

	public function __construct() {
		parent::__construct();
		$this->tagBuilderHelper = new WikiaTagBuilderHelper();
		$this->validator = new VKTagValidator();
	}

	static public function onParserFirstCallInit( Parser $parser ) {
		$parser->setHook( self::PARSER_TAG_NAME, [ new static(), 'renderTag' ] );
		return true;
	}

	public function renderTag( $input, array $args, Parser $parser, PPFrame $frame ) {
		$isValid = $this->validator->validateAttributes( $args );

		if ( !$isValid ) {
			return '<strong class="error">' . wfMessage( 'vk-tag-could-not-render' )->parse() . '</strong>';
		}

		$html = Html::element(
			'div',
			$this->buildTagAttributes( $args )
		);

		if ( !$this->tagBuilderHelper->isMobileSkin() ) {
			// Wrapper used for easily selecting the widget in Selenium tests
			$html = Html::rawElement( 'span', [ 'class' => 'widget-vk' ], $html );

			$parser->getOutput()->addModules( 'ext.wikia.VKTag' );
		}

		return $html;
	}

	private function buildTagAttributes( $args ) {
		$attributes = $this->tagBuilderHelper->buildTagAttributes( self::TAG_ALLOWED_ATTRIBUTES, $args, 'data' );

		// VK needs element id to be passed to the API, so let's give it one
		$attributes['id'] = 'vk-wrapper-' . wfRandomString( 6 );

		return array_merge( self::TAG_DEFAULT_ATTRIBUTES, $attributes );
	}

	protected function buildParamValidator( $paramName ) {
		return true;
	}
}
