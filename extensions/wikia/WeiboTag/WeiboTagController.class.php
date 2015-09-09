<?php
class WeiboTagController extends WikiaParserTagController {
	const PARSER_TAG_NAME = 'weibo';
	const IFRAME_SRC = 'http://widget.weibo.com/relationship/bulkfollow.php?';


	public static function onParserFirstCallInit( Parser $parser ) {
		$parser->setHook( self::PARSER_TAG_NAME, [ new static(), 'renderTag' ] );
		return true;
	}

	public function renderTag( $input, array $args, Parser $parser, PPFrame $frame ) {
		$url = self::buildIFrameSrc( $args );

		return Html::element( 'iframe',  [
			'class' => self::PARSER_TAG_NAME,
			'src' => $url,
			'scrolling' => 'yes',
			'frameborder' => 'no',
			'sandbox' => 'allow-scripts allow-same-origin',
			'seamless' => 'seamless',
			'data' => [ 'tag' => self::PARSER_TAG_NAME  ],
			'style' => ( isset( $args['style'] ) ? Sanitizer::checkCss( $args['style'] ) : '' )
		], wfMessage( 'weibotag-could-not-render' )->text() );
	}

	/**
	 * Generate the IFrame source for the weibo widget
	 * Converts parser tag attributes into URL parameters
	 *
	 * @see http://open.weibo.com/widget/bulkfollow.php
	 * @param array $args Tag attribute soup
	 * @return string Widget IFrame src
	 */
	private static function buildIFrameSrc( array $args ) {
		$allowedParams = [
			'color' => '',
			'count' => '',
			'dpc' => '',
			'language' => '',
			'sense' => '',
			'showinfo' => '1',
			'showtitle' => '1',
			'uids' => '',
			'verified' => '',
			'wide' => '',
		];

		foreach ( array_keys( $allowedParams ) as $name ) {
			if ( isset( $args[$name] ) ) {
				// Add user-defined parameter to URL
				$allowedParams[$name] = $args[$name];
			}
		}
		return self::IFRAME_SRC . http_build_query( $allowedParams );
	}

	protected function buildParamValidator( $paramName ) {
		return true;
	}
}
