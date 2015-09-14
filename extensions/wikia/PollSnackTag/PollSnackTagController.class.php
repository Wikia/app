<?php
class PollSnackTagController extends WikiaParserTagController {

	const PARSER_TAG_NAME = 'pollsnack';
	const TAG_SRC = 'http://files.quizsnack.com/iframe/embed.html?';
	const TAG_SOURCE_ALLOWED_PARAMS_WITH_DEFAULTS = [
		'hash' => '',
		// Width and height are defaults when generating iframe in PollSnack
		'width' => '250',
		'height' => '370',
		'wmode' => '',
		'bgcolor' => '',
	];
	const TAG_ALLOWED_ATTRIBUTES = [
		'width',
		'height',
	];
	const TAG_DEFAULT_ATTRIBUTES = [
		'data-wikia-widget' => self::PARSER_TAG_NAME,
		'scrolling' => 'no',
		'frameborder' => '0',
		'allowtransparency' => 'true',
		'seamless' => 'seamless',
		// Width and height are defaults when generating iframe in PollSnack
		'width' => '250',
		'height' => '370',
	];

	private $tagBuildSource;
	private $tagBuilderHelper;
	private $iFrameHelper;
	private $validator;

	public function __construct() {
		parent::__construct();
		$this->tagBuilderHelper = new WikiaTagBuilderHelper();
		$this->validator = new PollSnackTagValidator();
		$this->iFrameHelper = new WikiaIFrameTagBuilderHelper();
	}

	public static function onParserFirstCallInit( Parser $parser ) {
		$parser->setHook( self::PARSER_TAG_NAME, [ new static(), 'renderTag' ] );
		return true;
	}

	public function renderTag( $input, array $args, Parser $parser, PPFrame $frame ) {
		$isValid = $this->validator->validateAttributes( $args );
		if ( !$isValid ) {
			return '<strong class="error">' . wfMessage( 'pollsnack-tag-could-not-render' )->parse() . '</strong>';
		}

		$this->tagBuildSource = self::TAG_SRC . $this->tagBuilderHelper->buildTagSourceQueryParams(
				self::TAG_SOURCE_ALLOWED_PARAMS_WITH_DEFAULTS, $args
			);

		$iFrameHTML = Html::element(
			'iframe',
			$this->buildTagAttributes( $args )
		);

		return $this->iFrameHelper->wrapForMobile( $iFrameHTML );
	}

	private function buildTagAttributes( $args ) {
		$attributes = $this->tagBuilderHelper->buildTagAttributes( self::TAG_ALLOWED_ATTRIBUTES, $args );
		$attributes['src'] = $this->tagBuildSource;

		return array_merge( self::TAG_DEFAULT_ATTRIBUTES, $attributes );
	}


	protected function buildParamValidator( $paramName ) {
		return true;
	}
}
