<?php

use \Wikia\Logger\WikiaLogger;

class DesignSystemHelper {

	const DESIGN_SYSTEM_DIR = __DIR__ . '/bower_components/design-system';
	const ASSETS_DIR = self::DESIGN_SYSTEM_DIR . '/assets';

	private static $svgCache = [];

	/**
	 * @desc Returns SVG content
	 *
	 * @param string $group
	 * @param string $name
	 * @param string $classNames
	 * @param string $alt
	 *
	 * @return string
	 */
	public static function getSvg( $group, $name, $classNames = '', $alt = '' ) {
		$xml = self::getCachedSvg( $group, $name );

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
				'group' => $group,
				'name' => $name
			] );

			return $alt ?: $name ?: '';
		}
	}

	/**
	 * @desc Loads SVG file as a SimpleXMLElement object or gets it from cache
	 *
	 * @param string $group
	 * @param string $name
	 *
	 * @return SimpleXMLElement
	 */
	private static function getCachedSvg( $group, $name ) {
		if ( isset( self::$svgCache[ $group ][ $name ] ) ) {
			$xml = self::$svgCache[ $group ][ $name ];
		} else {
			$xml = simplexml_load_file( self::ASSETS_DIR . '/' . $group . '/' . $name . '.svg' );
			self::$svgCache[ $group ][ $name ] = $xml;
		}

		return $xml;
	}
}
