<?php
class WeiboTagController extends WikiaParserTagController {
	const PARSER_TAG_NAME = 'weibo';
	const TAG_SRC = 'http://widget.weibo.com/relationship/bulkfollow.php?';

	private $tagSourceAllowedParamsWithDefaults;
	private $tagAllowedAttributes;
	private $tagDefaultAttributes;
	private $tagBuildSource;
	private $tagBuilderHelper;


	public function __construct() {
		parent::__construct();

		$this->tagSourceAllowedParamsWithDefaults = [
			'color' => '',
			'count' => '',
			'dpc' => '',
			'language' => '',
			'sense' => '',
			'showinfo' => '1',
			'showtitle' => '1',
			'uids' => '',
			'verified' => '',
			'wide' => '',
		];

		$this->tagAllowedAttributes = [
			'width',
			'height',
			'scrolling',
			'frameborder',
			'style'
		];

		$this->tagDefaultAttributes = [
			'data-wikia-widget' => self::PARSER_TAG_NAME,
			'sandbox' => 'allow-scripts allow-same-origin',
			'seamless' => 'seamless'
		];

		$this->tagBuilderHelper = new TagBuilderHelper();
	}

	public static function onParserFirstCallInit( Parser $parser ) {
		$parser->setHook( self::PARSER_TAG_NAME, [ new static(), 'renderTag' ] );
		return true;
	}

	public function renderTag( $input, array $args, Parser $parser, PPFrame $frame ) {
		$this->tagBuildSource = self::TAG_SRC . $this->tagBuilderHelper->buildTagSourceQueryParams( $this->tagSourceAllowedParamsWithDefaults, $args );
		$iframe = Html::element( 'iframe',  $this->buildTagAttributes($args), wfMessage( 'weibotag-could-not-render' )->text() );
		if ( $this->app->checkSkin( [ 'wikiamobile', 'mercury' ] ) ) {
			return Html::rawElement( 'script',  ['type' => 'x-wikia-widget'], $iframe );
		} else {
			return $iframe;
		}
	}

	private function buildTagAttributes($args) {
		$attributes = $this->tagBuilderHelper->buildTagAttributes($this->tagAllowedAttributes, $args);
		$attributes['src'] = $this->tagBuildSource;
		return array_merge($attributes, $this->tagDefaultAttributes);
	}


	protected function buildParamValidator( $paramName ) {
		return true;
	}
}
