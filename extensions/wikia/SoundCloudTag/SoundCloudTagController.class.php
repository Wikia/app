<?php
class SoundCloudTagController extends WikiaParserTagController {
	const PARSER_TAG_NAME = 'soundcloud';
	const API_ENDPOINT = 'https://w.soundcloud.com/player/?';


	public static function onParserFirstCallInit( Parser $parser ) {
		$parser->setHook( self::PARSER_TAG_NAME, [ new static(), 'renderTag' ] );
		return true;
	}

	public function renderTag( $input, array $args, Parser $parser, PPFrame $frame ) {

		return Html::element(
			'iframe',
			$this->prepareAttributes( $args ),
			wfMessage( 'soundcloud-tag-could-not-render' )->text()
		);
	}

	private function prepareAttributes( array $args ) {
		$allowedArgs = ['width', 'height', 'scrolling', 'frameborder'];
		$attributes = [];

		if ( array_key_exists('style', $args) ) {
			$attributes['style'] = Sanitizer::checkCss( $args['style'] );
		}

		if ( array_key_exists('src', $args) ) {
			$attributes['src'] = $args['src'];
		}

		foreach ( $allowedArgs as $name ) {
			if ( isset( $args[$name] ) ) {
				$attributes[$name] = $args[$name];
			}
		}

		$attributes['data-tag'] = 'soundcloud';
		$attributes['sandbox'] = 'allow-scripts allow-same-origin';
		$attributes['seamless'] = 'seamless';

		return $attributes;
	}

	protected function buildParamValidator( $paramName ) {
		return true;
	}
}
