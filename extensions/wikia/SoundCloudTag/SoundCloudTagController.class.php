<?php
class SoundCloudTagController extends WikiaParserTagController {
	const TAG_NAME = 'soundcloud';

	const TAG_SRC = 'https://w.soundcloud.com/player/?';

	const PARAMS_WITH_DEFAULTS = [
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
		'scrolling',
		'frameborder',
		'style',
	];

	const TAG_DEFAULT_ATTRIBUTES = [
		'data-wikia-widget' => self::TAG_NAME,
		'sandbox' => 'allow-scripts allow-same-origin',
		'seamless' => 'seamless',
	];

	public static function onParserFirstCallInit( Parser $parser ) {
		$parser->setHook( self::TAG_NAME, [ new static(), 'renderTag' ] );
		return true;
	}

	public function renderTag( $input, array $args, Parser $parser, PPFrame $frame ) {
		$sourceUrlParams = $this->buildTagSourceQueryParams( $args );

		return Html::element(
			'iframe',
			$this->buildTagAttributes( $sourceUrlParams, $args ),
			wfMessage( 'soundcloud-tag-could-not-render' )->text()
		);
	}


	private function buildTagSourceQueryParams( array $userParams ) {
		$allowedParams = self::PARAMS_WITH_DEFAULTS;

		foreach ( array_keys( $allowedParams ) as $name ) {
			if ( isset( $userParams[$name] ) ) {
				$allowedParams[$name] = $userParams[$name];
			}
		}

		return http_build_query( $allowedParams );
	}

	private function buildTagAttributes( $sourceUrlParams, array $userAttributes ) {
		$attributes = [];

		foreach ( self::TAG_ALLOWED_ATTRIBUTES as $name ) {
			if ( isset( $userAttributes[$name] ) ) {
				if ($name === 'style') {
					$attributes['style'] = Sanitizer::checkCss( $userAttributes['style'] );
				} else {
					$attributes[$name] = $userAttributes[$name];
				}
			}
		}

		$attributes['src'] = self::TAG_SRC . $sourceUrlParams;
		return array_merge( self::TAG_DEFAULT_ATTRIBUTES, $attributes );
	}

	protected function buildParamValidator( $paramName ) {
		return true;
	}
}
