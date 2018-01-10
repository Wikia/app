<?php
class PollSnackTagController extends WikiaController {

	const PARSER_TAG_NAME = 'pollsnack';

	// files.quizsnack.com does not yet support HTTPS, to handle in (PLATFORM-3285)
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

	private $helper;
	private $validator;

	public function __construct() {
		parent::__construct();

		$this->helper = new WikiaIFrameTagBuilderHelper();
		$this->validator = new PollSnackTagValidator();
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

		$queryParamsOverride = [];
		if ( $this->helper->isMobileSkin() ) {
			/**
			 * This is needed because for mobile devices:
			 * - we want content (external too!) to be responsive
			 * - PollSnack checks if browser supports Flash and:
			 *   - if yes then loads <embed> element
			 *   - if no then loads another iframe (HTML5) and passes parameters from the original URL
			 *
			 * Issue with the last item is that if we don't put `width` in the URL
			 * then the second iframe gets `width=undefined` and doesn't load at all.
			 *
			 * Trying to load the HTML5 iframe directly results in AccessDenied error
			 * so this is the only working solution I found.
			 */
			$queryParamsOverride = [
				'width' => ''
			];
		}

		$sourceUrl = self::TAG_SRC . $this->helper->buildTagSourceQueryParams(
				self::TAG_SOURCE_ALLOWED_PARAMS_WITH_DEFAULTS, $args, $queryParamsOverride
			);

		$iFrameHTML = Html::element(
			'iframe',
			$this->buildTagAttributes( $sourceUrl, $args )
		);

		return $this->helper->wrapForMobile( $iFrameHTML );
	}

	private function buildTagAttributes( $sourceUrl, $args ) {
		$attributes = $this->helper->buildTagAttributes( self::TAG_ALLOWED_ATTRIBUTES, $args );
		$attributes['src'] = $sourceUrl;

		return array_merge( self::TAG_DEFAULT_ATTRIBUTES, $attributes );
	}
}
