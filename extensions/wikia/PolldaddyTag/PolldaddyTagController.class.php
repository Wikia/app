<?php
class PolldaddyTagController extends WikiaController {

	const PARSER_TAG_NAME = 'polldaddy';
	const NAME = 'Polldaddy';

	const TAG_ALLOWED_ATTRIBUTES = [
		'id',
	];

	const DATA_WIKI_WIDGET_ATTRIBUTE = [
		'data-wikia-widget' => self::PARSER_TAG_NAME,
	];

	private $helper;
	private $validator;

	public function __construct() {
		parent::__construct();

		$this->helper = new WikiaIFrameTagBuilderHelper();
		$this->validator = new PolldaddyTagValidator();
	}

	public static function onParserFirstCallInit( Parser $parser ) {
		$parser->setHook( self::PARSER_TAG_NAME, [ new static(), 'renderTag' ] );
		return true;
	}

	public function renderTag( $input, array $args, Parser $parser, PPFrame $frame ) {
		$isValid = $this->validator->validateAttributes( $args );

		if ( !$isValid ) {
			return '<strong class="error">' . wfMessage( 'polldaddy-tag-could-not-render' )->parse() . '</strong>';
		}

		$attributes = $this->helper->buildTagAttributes( self::TAG_ALLOWED_ATTRIBUTES, $args );

		if ( $this->helper->isMobileSkin() ) {
			return Html::element( 'a', array_merge( $attributes, self::DATA_WIKI_WIDGET_ATTRIBUTE ), self::NAME );
		} else {
			return Html::rawElement(
				'span', self::DATA_WIKI_WIDGET_ATTRIBUTE,
				trim( $this->sendRequest('PolldaddyTagController', 'showDesktop', $attributes) )
			);
		}
	}

	public function showDesktop() {
		$this->setVal( 'id', $this->getVal( 'id' ) );

		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );
	}
}
