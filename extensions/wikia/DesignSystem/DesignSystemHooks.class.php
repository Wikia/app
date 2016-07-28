<?php
class DesignSystemHooks {

	const DESIGN_SYSTEM_DIR = __DIR__ . '/bower_components/design-system/dist';

	/**
	 * @desc Adds Design System styles to all Oasis pages
	 *
	 * @param OutputPage $out
	 *
	 * @return bool true
	 */
	public static function onBeforePageDisplay( $out, &$skin ) {

		if ( F::app()->checkSkin( 'oasis', $skin ) ) {
			\Wikia::addAssetsToOutput( 'design_system_scss' );
		}

		return true;
	}

	/**
	 * @desc Injects Design System SVG symbols in all Oasis pages
	 *
	 * @param $skin
	 * @param $afterBodyHtml
	 *
	 * @return bool
	 */
	public static function onGetHTMLAfterBody( $skin, &$afterBodyHtml ) {
		if ( F::app()->checkSkin( 'oasis', $skin ) ) {
			$afterBodyHtml .= self::getSvgSymbols();
		}

		return true;
	}

	/**
	 * @desc Returns SVG symbols wrapped in an invisible container, ready to be injected in HTML
	 *
	 * @return string
	 */
	public static function getSvgSymbols() {
		$symbols = [
			file_get_contents( self::DESIGN_SYSTEM_DIR . '/company.svg' ),
			file_get_contents( self::DESIGN_SYSTEM_DIR . '/icons.svg' )
		];

		$svgContainer = '<div style="height: 0; width: 0; position: absolute;">';

		foreach ( $symbols as $symbol ) {
			$svgContainer .= $symbol;
		}

		$svgContainer .= '</div>';

		return $svgContainer;
	}
}
