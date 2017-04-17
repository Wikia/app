<?php

/**
 * Hook handlers for the SoundCloud extension
 */
class SoundCloudHooks {

	/**
	 * SoundCloud widget API HTTP endpoint
	 * @var string
	 */
	const SC_API_ENDPOINT = 'https://w.soundcloud.com/player/?';

	/**
	 * Hook: ParserFirstCallInit
	 * Registers the <soundcloud> tag with the MW parser
	 *
	 * @param Parser $parser
	 * @return bool true to continue hook processing
	 * @throws MWException
	 */
	public static function onParserFirstCallInit( Parser $parser ) {
		$parser->setHook( 'soundcloud', 'SoundCloudHooks::renderWidget' );
		return true;
	}

	/**
	 * Output the SoundCloud widget
	 * Called by the parser for each <soundcloud> tag
	 *
	 * @param string $input Tag contents (unused)
	 * @param array $args Tag attribute soup
	 * @param Parser $parser
	 * @param PPFrame $frame
	 * @return string Widget HTML
	 */
	public static function renderWidget( $input, array $args, Parser $parser, PPFrame $frame ) {
		$url = self::getWidgetURL( $args );
		$parser->getOutput()->addModuleStyles( 'ext.SoundCloud' );
		// We only show an error message if we couldn't make a connection to SoundCloud at all.
		// The SoundCloud widget API will take care of other errors.
		return Html::element( 'iframe',  [
			'class' => 'soundcloud-widget',
			'src' => $url,
			'sandbox' => 'allow-scripts allow-same-origin',
			'seamless' => 'seamless',
			'style' => ( isset( $args['style'] ) ? Sanitizer::checkCss( $args['style'] ) : '' )
		], wfMessage( 'soundcloud-could-not-render' )->text() );
	}

	/**
	 * Generate the URL for the current widget
	 * Converts tag attributes into URL parameters
	 *
	 * @see https://developers.soundcloud.com/docs/api/html5-widget#params
	 * @param array $args Tag attribute soup
	 * @return string Widget URL
	 */
	protected static function getWidgetURL( array $args ) {
		$data = [];
		$validParams = F::app()->wg->SoundCloudParameterSettings;
		foreach ( array_keys( $validParams ) as $name ) {
			if ( isset( $args[$name] ) ) {
				// Add user-defined parameter to URL
				$data[$name] = $args[$name];
			} else if ( $validParams[$name] !== '' ) {
				// If our settings override SoundCloud's defaults, add them
				$data[$name] = $validParams[$name];
			}
		}

		return self::SC_API_ENDPOINT . http_build_query( $data );
	}
}
