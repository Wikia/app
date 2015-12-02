<?php
class GoogleFormTagController extends WikiaController {
	const TAG_NAME = 'googleform';

	const GOOGLE_FORM_BASE_URL = 'https://docs.google.com';

	const TAG_ALLOWED_ATTRIBUTES = [
		'width',
		'height',
	];

	const TAG_DEFAULT_ATTRIBUTES = [
		'data-wikia-widget' => self::TAG_NAME,
		'frameborder' => '0',
		'marginheight' => '0',
		'marginwidth' => '0',
		//Default for height comes from default value added by Google when creating an iFrame via their website
		'width' => '760',
		'height' => '500',
	];

	private $helper;

	public function __construct() {
		parent::__construct();

		$this->helper = new WikiaIFrameTagBuilderHelper();
	}

	public static function onParserFirstCallInit( Parser $parser ) {
		$parser->setHook( self::TAG_NAME, [ new static(), 'renderTag' ] );
		return true;
	}

	public function renderTag( $input, array $args, Parser $parser, PPFrame $frame ) {
		$sourceUrl = $this->cleanupUrl( $args['url'] );

		if (
			empty( $sourceUrl ) ||
			substr( $sourceUrl, 0, strlen( self::GOOGLE_FORM_BASE_URL ) ) !== self::GOOGLE_FORM_BASE_URL
		) {
			return '<strong class="error">' . wfMessage( 'google-form-tag-malformed-url' )->parse() . '</strong>';
		}

		$iframeCode = Html::element(
			'iframe',
			$this->buildTagAttributes( $sourceUrl, $args )
		);

		return $this->helper->wrapForMobile( $iframeCode );
	}

	private function buildTagAttributes( $sourceUrl,  array $userAttributes ) {
		$attributes = $this->helper->buildTagAttributes( self::TAG_ALLOWED_ATTRIBUTES, $userAttributes );

		$attributes['src'] = $sourceUrl;

		return array_merge( self::TAG_DEFAULT_ATTRIBUTES, $attributes );
	}

	private function cleanupUrl( $url ) {
		return filter_var( $url, FILTER_VALIDATE_URL, FILTER_SANITIZE_URL | FILTER_FLAG_PATH_REQUIRED );
	}
}
