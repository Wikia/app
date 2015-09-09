<?php
class SoundCloudTagController extends WikiaParserTagController {
	const PARSER_TAG_NAME = 'soundcloud';
	const API_ENDPOINT = 'https://w.soundcloud.com/player/?';


	public static function onParserFirstCallInit( Parser $parser ) {
		$parser->setHook( self::PARSER_TAG_NAME, [ new static(), 'renderTag' ] );
		return true;
	}

	public function renderTag( $input, array $args, Parser $parser, PPFrame $frame ) {
		$url = self::buildUrl( $args );

		// We only show an error message if we couldn't make a connection to SoundCloud at all.
		// The SoundCloud widget API will take care of other errors.
		return Html::element( 'iframe',  [
			'class' => '',
			'src' => $url,
			'sandbox' => 'allow-scripts allow-same-origin',
			'seamless' => 'seamless',
			'allowtransparency' => 'true',
			'scrolling' => 'no',
			'frameborder' => 'no',
			'data-tag' => 'soundcloud',
			'style' => ( isset( $args['style'] ) ? Sanitizer::checkCss( $args['style'] ) : '' )
		], wfMessage( 'soundcloud-tag-could-not-render' )->text() );
	}

	/**
	 * Generate the URL for the current widget
	 * Converts tag attributes into URL parameters
	 *
	 * @see https://developers.soundcloud.com/docs/api/html5-widget#params
	 * @param array $args Tag attribute soup
	 * @return string Widget URL
	 */
	private static function buildUrl( array $args ) {
		$currentParams = [
			'color' => '',
			'url' => '',
			'auto_play' => '',
			'buying' => '',
			'liking' => '',
			'download' => '',
			'sharing' => '',
			'show_artwork' => 'false',
			'show_comments' => '',
			'show_playcount' => '',
			'show_user' => '',
			'start_track' => ''
		];

		foreach ( array_keys( $currentParams ) as $name ) {
			if ( isset( $args[$name] ) ) {
				// Add user-defined parameter to URL
				$currentParams[$name] = $args[$name];
			}
		}
		return self::API_ENDPOINT . http_build_query( $currentParams );
	}

	protected function buildParamValidator( $paramName ) {
		return true;
	}
}
