<?php

use \Wikia\Logger\WikiaLogger;

class DesignSystemHelper {

	const DESIGN_SYSTEM_DIR = __DIR__ . '/bower_components/design-system';
	const ASSETS_DIR = self::DESIGN_SYSTEM_DIR . '/assets';

	private static $svgCache = [];

	/**
	 * @desc Returns SVG content
	 *
	 * @param string $name
	 * @param string $classNames
	 * @param string $alt
	 *
	 * @return string
	 */
	public static function getSvg( $name, $classNames = '', $alt = '' ) {
		$xml = self::getCachedSvg( $name );

		if ( $xml instanceof SimpleXMLElement ) {
			/* @var $xml SimpleXMLElement */

			if ( !empty( $classNames ) ) {
				$xml->addAttribute( 'class', $classNames );
			}

			if ( !empty( $alt ) ) {
				$xml->addAttribute( 'alt', $alt );
			}

			return $xml->asXML();
		} else {
			WikiaLogger::instance()->error( 'Design System SVG could not be loaded', [
				'name' => $name
			] );

			return $alt ?: $name ?: '';
		}
	}

	/**
	 * @desc Loads SVG file as a SimpleXMLElement object or gets it from cache
	 *
	 * @param string $name
	 *
	 * @return SimpleXMLElement
	 */
	private static function getCachedSvg( $name ) {
		if ( isset( self::$svgCache[ $name ] ) ) {
			$xml = self::$svgCache[ $name ];
		} else {
			$xml = simplexml_load_file( self::ASSETS_DIR . '/' . self::resolveSvgPath( $name ) . '.svg' );
			self::$svgCache[ $name ] = $xml;
		}

		return $xml;
	}

	/**
	 * @desc DesignSystem API returns SVG names in format `wds-{group}-{name}`
	 *       We need to convert it to path `{group}/{name}` to access the correct SVG file
	 *
	 * @param string $name
	 *
	 * @return string
	 */
	private static function resolveSvgPath( $name ) {
		$name = substr_replace( $name, '', 0, 4 );
		$firstDashPosition = strpos( $name, '-' );
		$path = substr_replace( $name, '/', $firstDashPosition, 1 );

		return $path;
	}
}
