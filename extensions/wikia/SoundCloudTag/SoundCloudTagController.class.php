<?php
class SoundCloudTagController extends WikiaParserTagController {
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
	];

	private $helper;

	public function __construct() {
		parent::__construct();

		$this->helper = new WikiaIFrameTagBuilderHelper();
	}

	public function getTagName() {
		return self::TAG_NAME;
	}

	protected function getErrorOutput( $errorMessages ) {
		return wfMessage( 'soundcloud-tag-could-not-render' )->text();
	}

	protected function getSuccessOutput( $args ) {
		$sourceUrl = self::TAG_SRC . $this->helper->buildTagSourceQueryParams(
				self::TAG_SOURCE_ALLOWED_PARAMS_WITH_DEFAULTS, $args
			);

		$iframeCode = Html::element(
			'iframe',
			$this->buildTagAttributes( $sourceUrl, $args ),
			wfMessage( 'soundcloud-tag-could-not-render' )->text()
		);

		return $this->helper->wrapForMobile( $iframeCode );
	}

	private function buildTagAttributes( $sourceUrlParams, array $userAttributes ) {
		$attributes = $this->helper->buildTagAttributes( self::TAG_ALLOWED_ATTRIBUTES, $userAttributes );

		$attributes['src'] = self::TAG_SRC . $sourceUrlParams;
		return array_merge( self::TAG_DEFAULT_ATTRIBUTES, $attributes );
	}

	protected function buildParamValidator( $paramName ) {
		return true;
	}
}
