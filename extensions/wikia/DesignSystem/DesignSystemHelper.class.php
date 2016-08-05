<?php

use \Wikia\Logger\WikiaLogger;

class DesignSystemHelper {

	const DESIGN_SYSTEM_DIR = __DIR__ . '/bower_components/design-system';
	const SVG_DIR = self::DESIGN_SYSTEM_DIR . '/dist/svg';

	const MESSAGE_PARAMS_ORDER = [
		'global-footer-licensing-and-vertical-description' => [
			'sitename',
			'vertical',
			'license'
		]
	];

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
	public static function getCachedSvg( $name ) {
		if ( isset( self::$svgCache[ $name ] ) ) {
			$xml = self::$svgCache[ $name ];
		} else {
			$xml = simplexml_load_file( self::SVG_DIR . '/' . $name . '.svg' );
			self::$svgCache[ $name ] = $xml;
		}

		return $xml;
	}

	public static function renderText( $fields ) {
		if ( $fields['type'] === 'text' ) {
			return $fields['value'];
		}

		if ( $fields['type'] === 'translatable-text' ) {
			if ( isset( $fields['params'] ) ) {
				$paramsRendered = [];

				foreach ( self::MESSAGE_PARAMS_ORDER[$fields['key']] as $index => $paramKey ) {
					$paramsRendered[] = self::renderText( $fields['params'][$paramKey] );
				}

				return wfMessage( $fields['key'] )->rawParams( $paramsRendered )->escaped();
			} else {
				return wfMessage( $fields['key'] )->escaped();
			}
		}

		if ( $fields['type'] === 'link-text' ) {
			return '<a href="' . $fields['href'] . '">' . self::renderText( $fields['title'] ) . '</a>';
		}
	}
}
