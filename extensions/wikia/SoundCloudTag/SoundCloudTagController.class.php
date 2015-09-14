<?php
class SoundCloudTagController extends WikiaController {
	const TAG_NAME = 'soundcloud';

	const TAG_SRC = 'https://w.soundcloud.com/player/?';

	const TAG_SOURCE_ALLOWED_PARAMS_WITH_DEFAULTS = [
		'url' => '',
		'color' => '',
		'auto_play' => '',
		'buying' => '',
		'liking' => '',
		'download' => '',
		'sharing' => '',
		'show_artwork' => 'false',
		'show_comments' => '',
		'show_playcount' => '',
		'show_user' => '',
		'start_track' => '',
	];

	const TAG_ALLOWED_ATTRIBUTES = [
		'width',
		'height',
	];

	const TAG_DEFAULT_ATTRIBUTES = [
		'data-wikia-widget' => self::TAG_NAME,
		'scrolling' => 'no',
		'frameborder' => 'no',
		//Default for height comes from default value added by SoundCloud when creating an iFrame via their website
		'height' => '465',
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
		$sourceUrl = self::TAG_SRC . $this->helper->buildTagSourceQueryParams(
				self::TAG_SOURCE_ALLOWED_PARAMS_WITH_DEFAULTS, $args
			);

		$iframeCode = Html::element(
			'iframe',
			$this->buildTagAttributes( $sourceUrl, $args )
		);

		return $this->helper->wrapForMobile( $iframeCode );
	}

	private function buildTagAttributes( $sourceUrlParams, array $userAttributes ) {
		$attributes = $this->helper->buildTagAttributes( self::TAG_ALLOWED_ATTRIBUTES, $userAttributes );

		$attributes['src'] = $sourceUrlParams;
		return array_merge( self::TAG_DEFAULT_ATTRIBUTES, $attributes );
	}
}
