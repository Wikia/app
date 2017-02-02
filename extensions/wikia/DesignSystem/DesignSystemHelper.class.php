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
		],
		'global-navigation-search-placeholder-in-wiki' => [
			'sitename',
		],
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
	public static function renderSvg( $name, $classNames = '', $alt = '' ) {
		$xml = static::getCachedSvg( $name );

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
			WikiaLogger::instance()->error(
				'Design System SVG could not be loaded',
				[
					'name' => $name
				]
			);

			return $alt ?: $name ?: '';
		}
	}

	public static function renderApiImage( $model, $classNames = '', $alt = '' ) {
		if ( $model['type'] === 'wds-svg' ) {
			return static::renderSvg( $model['name'], $classNames, $alt );
		} elseif ($model['type'] === 'image-external') {
			$imgXml = new SimpleXMLElement( '<img />' );
			$imgXml->addAttribute( 'src', $model['url'] );
			$imgXml->addAttribute( 'class', $classNames );
			$imgXml->addAttribute( 'alt', $alt );

			$dom = dom_import_simplexml( $imgXml );
			return $dom->ownerDocument->saveXML( $dom->ownerDocument->documentElement );
		}

		WikiaLogger::instance()->error( __METHOD__ . ': unhandled image type:' . $model['type'] );
		return '';
	}

	/**
	 * @desc Loads SVG file as a SimpleXMLElement object or gets it from cache
	 *
	 * @param string $name
	 *
	 * @return SimpleXMLElement
	 */
	private static function getCachedSvg( $name ) {
		if ( isset( static::$svgCache[$name] ) ) {
			$xml = static::$svgCache[$name];
		} else {
			$xml = simplexml_load_file( static::SVG_DIR . '/' . $name . '.svg' );
			static::$svgCache[$name] = $xml;
		}

		return ( $xml instanceof SimpleXMLElement ) ? clone $xml : null;
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
		if ( $recursionDepth > static::MAX_RECURSION_DEPTH ) {
			WikiaLogger::instance()->error( 'Recursion depth maximum reached' );

			return '';
		}

		if ( $fields['type'] === 'text' ) {
			return htmlspecialchars( $fields['value'] );
		} elseif ( $fields['type'] === 'translatable-text' ) {
			if ( isset( $fields['params'] ) ) {
				$paramsRendered = [ ];

				if ( !array_key_exists( $fields['key'], static::MESSAGE_PARAMS_ORDER ) ) {
					WikiaLogger::instance()->error(
						'Design System tried to render a message with params that we don\'t support, ignore params',
						[
							'messageKey' => $fields['key'],
							'params' => $fields['params']
						]
					);
				} else {
					foreach ( static::MESSAGE_PARAMS_ORDER[$fields['key']] as $paramKey ) {
						$paramsRendered[] = static::renderText( $fields['params'][$paramKey], $recursionDepth + 1 );
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
				static::renderText( $fields['title'], $recursionDepth + 1 )
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
