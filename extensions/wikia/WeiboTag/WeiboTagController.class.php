<?php
class WeiboTagController extends WikiaParserTagController {
	const PARSER_TAG_NAME = 'weibo';
	const IFRAME_SRC = 'http://widget.weibo.com/relationship/bulkfollow.php?';
	private $IFRAME_SOURCE_ALLOWED_PARAMS;
	private $IFRAME_ALLOWED_ATTRIBUTES;
	private $IFRAME_DEFAULT_ATTRIBUTES;
	private $iFrameSource;
	private $iFrameBuilderHelper;


	public function __construct() {
		parent::__construct();

		$this->IFRAME_SOURCE_ALLOWED_PARAMS = [
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

		$this->IFRAME_ALLOWED_ATTRIBUTES = [
			'width',
			'height',
			'scrolling',
			'frameborder',
			'style'
		];

		$this->IFRAME_DEFAULT_ATTRIBUTES = [
			'data-tag' => self::PARSER_TAG_NAME,
			'sandbox' => 'allow-scripts allow-same-origin',
			'seamless' => 'seamless'
		];

		$this->iFrameBuilderHelper = new IFrameBuilderHelper();
	}

	public static function onParserFirstCallInit( Parser $parser ) {
		$parser->setHook( self::PARSER_TAG_NAME, [ new static(), 'renderTag' ] );
		return true;
	}

	public function renderTag( $input, array $args, Parser $parser, PPFrame $frame ) {
		$this->iFrameSource = self::IFRAME_SRC . $this->iFrameBuilderHelper->buildIFrameSourceQueryParams( $this->IFRAME_SOURCE_ALLOWED_PARAMS, $args );
		return Html::element( 'iframe',  $this->buildIFrameAttributes($args), wfMessage( 'weibotag-could-not-render' )->text() );
	}

	private function buildIFrameAttributes($args) {
		$attributes = $this->iFrameBuilderHelper->buildIFrameAttributes($this->IFRAME_ALLOWED_ATTRIBUTES, $args);
		$attributes['src'] = $this->iFrameSource;
		return array_merge($attributes, $this->IFRAME_DEFAULT_ATTRIBUTES);
	}


	protected function buildParamValidator( $paramName ) {
		return true;
	}
}
