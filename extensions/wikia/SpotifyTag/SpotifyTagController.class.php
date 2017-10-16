<?php
class SpotifyTagController extends WikiaController {
	const TAG_NAME = 'spotify';

	const TAG_SRC = 'https://embed.spotify.com/?';

	const TAG_SOURCE_ALLOWED_PARAMS_WITH_DEFAULTS = [
		'uri' => '',
		'view' => '',
		'theme' => '',
	];

	const TAG_ALLOWED_ATTRIBUTES = [
		'width',
		'height',
	];

	const TAG_DEFAULT_ATTRIBUTES = [
		'data-wikia-widget' => self::TAG_NAME,
		'allowtransparency' => 'true',
		'frameborder' => '0',
		'width' => '300',
		'height' => '380',
	];

	private $helper;
	private $validator;

	public function __construct() {
		parent::__construct();

		$this->helper = new WikiaIFrameTagBuilderHelper();
		$this->validator = new SpotifyTagValidator();
	}

	public static function onParserFirstCallInit( Parser $parser ) {
		$parser->setHook( self::TAG_NAME, [ new static(), 'renderTag' ] );
		return true;
	}

	public function renderTag( $input, array $args, Parser $parser, PPFrame $frame ) {
		$isValid = $this->validator->validateAttributes( $args );

		if ( !$isValid ) {
			return '<strong class="error">' . wfMessage( 'spotify-tag-could-not-render' )->parse() . '</strong>';
		}

		$sourceUrl = self::TAG_SRC . $this->helper->buildTagSourceQueryParams(
			self::TAG_SOURCE_ALLOWED_PARAMS_WITH_DEFAULTS, $args
		);

		$iframeCode = Html::element( 'iframe', $this->buildTagAttributes( $sourceUrl, $args ) );

		return $this->helper->wrapForMobile( $iframeCode );
	}

	private function buildTagAttributes( $sourceUrl, array $userAttributes ) {
		$attributes = $this->helper->buildTagAttributes( self::TAG_ALLOWED_ATTRIBUTES, $userAttributes );

		$attributes['src'] = $sourceUrl;
		return array_merge( self::TAG_DEFAULT_ATTRIBUTES, $attributes );
	}
}
