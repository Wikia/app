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
			'allowtransparency' => 'true',
			'class' => '',
			'data-tag' => 'soundcloud',
			'frameborder' => 'no',
			'sandbox' => 'allow-scripts allow-same-origin',
			'scrolling' => 'no',
			'seamless' => 'seamless',
			'src' => $url,
			'style' => ( isset( $args['style'] ) ? Sanitizer::checkCss( $args['style'] ) : '' )
		], wfMessage( 'soundcloud-tag-could-not-render' )->text() );
	}

	/**
	 * Generate the URL for the current widget
	 *
	 * @see https://developers.soundcloud.com/docs/api/html5-widget#params
	 *
	 * @param array $args
	 * @return string
	 */
	private static function buildUrl( array $args ) {
		// basically white-list of attributes
		$allowedParams = [ 'auto_play', 'buying', 'color', 'download', 'liking', 'sharing', 'show_artwork','show_comments', 'show_playcount', 'show_user', 'start_track', 'url' ];
		$data = [];

		foreach ( $allowedParams as $name ) {
			if ( isset( $args[$name] ) ) {
				$data[$name] = $args[$name];
			}
		}
		return self::API_ENDPOINT . http_build_query( $data );
	}

	protected function buildParamValidator( $paramName ) {
		return true;
	}
}
