<?php
class PolldaddyTagController extends WikiaController {

	const PARSER_TAG_NAME = 'polldaddy';
	const NAME = 'Polldaddy';

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

	public static function onWikiaMobileAssetsPackages( Array &$jsBodyPackages, Array &$jsExtensionPackages, Array &$scssPackages ) {
		$jsExtensionPackages[] = 'polldaddy_tag_wikiamobile';
		return true;
	}

	public function renderTag( $input, array $args, Parser $parser, PPFrame $frame ) {
		$isValid = $this->validator->validateAttributes( $args );

		if ( !$isValid ) {
			return '<strong class="error">' . wfMessage( 'polldaddy-tag-could-not-render' )->parse() . '</strong>';
		}

		/**
		 * Warning: as we're using user provided ID number to construct ID of an element it HAS TO BE
		 * unique on the page - in other words: including widget for the SECOND time will not have any
		 * effect - all content will be rendered inside FIRST element, overriding it.
		 */

		return $this->helper->isMobileSkin() ?
			Html::element(
				'a',
				array_merge( self::DATA_WIKI_WIDGET_ATTRIBUTE, [ 'data-id' => $args['id'] ] )
			) :
			Html::rawElement(
				'span',
				self::DATA_WIKI_WIDGET_ATTRIBUTE,
				trim( $this->sendRequest('PolldaddyTagController', 'showDesktop', $args) )
			);
	}

	public function showDesktop() {
		$this->setVal( 'id', $this->getVal( 'id' ) );

		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );
	}
}
