<?php

use \Wikia\Logger\WikiaLogger;

class DesignSystemHelper {

	const DESIGN_SYSTEM_DIR = __DIR__ . '/bower_components/design-system';
	const SVG_DIR = self::DESIGN_SYSTEM_DIR . '/dist/svg';

	// keep in sync with DesignSystem/i18n/build.js
	const MESSAGE_PARAMS_ORDER = [
		'global-footer-licensing-and-vertical-description' => [
			'sitename',
			'vertical',
			'license'
		]
	];

	const MAX_RECURSION_DEPTH = 10;

	private static $svgCache = [ ];

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

			// We don't use asXML() method to skip XML Declaration tag that causes warnings in browsers
			$dom = dom_import_simplexml( $xml );
			return $dom->ownerDocument->saveXML( $dom->ownerDocument->documentElement );

		} else {
			WikiaLogger::instance()->error(
				'Design System SVG could not be loaded',
				[
					'name' => $name
				]
			);

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
		if ( isset( self::$svgCache[$name] ) ) {
			$xml = self::$svgCache[$name];
		} else {
			$xml = simplexml_load_file( self::SVG_DIR . '/' . $name . '.svg' );
			self::$svgCache[$name] = $xml;
		}

		return $xml;
	}

	/**
	 * @desc Renders text based on value of the `type` field, supports following types:
	 *       - text
	 *       - translatable-text
	 *       - link-text
	 *
	 * @param array $fields
	 * @param int $recursionDepth
	 *
	 * @return string
	 */
	public static function renderText( $fields, $recursionDepth = 0 ) {
		if ( $recursionDepth > self::MAX_RECURSION_DEPTH ) {
			WikiaLogger::instance()->error( 'Recursion depth maximum reached' );

			return '';
		}

		if ( $fields['type'] === 'text' ) {
			return htmlspecialchars( $fields['value'] );
		} elseif ( $fields['type'] === 'translatable-text' ) {
			if ( isset( $fields['params'] ) ) {
				$paramsRendered = [ ];

				if ( !array_key_exists( $fields['key'], self::MESSAGE_PARAMS_ORDER ) ) {
					WikiaLogger::instance()->error(
						'Design System tried to render a message with params that we don\'t support, ignore params',
						[
							'messageKey' => $fields['key'],
							'params' => $fields['params']
						]
					);
				} else {
					foreach ( self::MESSAGE_PARAMS_ORDER[$fields['key']] as $paramKey ) {
						$paramsRendered[] = self::renderText( $fields['params'][$paramKey], $recursionDepth + 1 );
					}
				}

				return wfMessage( $fields['key'] )->rawParams( $paramsRendered )->escaped();
			} else {
				return wfMessage( $fields['key'] )->escaped();
			}
		} elseif ( $fields['type'] === 'link-text' ) {
			return Html::rawElement(
				'a',
				[
					'href' => $fields['href']
				],
				self::renderText( $fields['title'], $recursionDepth + 1 )
			);
		} else {
			WikiaLogger::instance()->error(
				'Design System tried to render a text of unsupported type',
				[
					'fields' => $fields
				]
			);

			return '';
		}
	}
}
