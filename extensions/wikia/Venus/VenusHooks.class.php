<?php

class VenusHooks {

	const INFOBOX_CLASS_NAME = 'infobox';

	static public $stylesBlacklist = [
		'width',
		'height'
	];

	/**
	 * Check if infobox (div element or table which contains 'infobox' string in class attribute)
	 * exists in first article section, and extract it from this section
	 *
	 * @param Parser $parser Parser instance
	 * @param integer $section number of section in article text
	 * @param string $content reference to section content
	 * @param boolean $showEditLinks  should add edit link
	 * @return bool
	 */
	static public function onParserSectionCreate( $parser, $section, &$content, $showEditLinks ) {
		if ( self::isInfoboxInFirstSection( $parser, $section, $content ) ) {
			$dom = DOMDocument::loadHTML($content, LIBXML_HTML_NOIMPLIED);
			$finder = new DOMXPath($dom);
			$query = "((//div|//table)[contains(translate(@class, '" . strtoupper( self::INFOBOX_CLASS_NAME ). "', '" .
				self::INFOBOX_CLASS_NAME . "'), '" . self::INFOBOX_CLASS_NAME . "')])[1]";
			$nodes = $finder->query($query);
			$node = $nodes->item(0);

			if (!is_null($node)) {
				$body = $dom->documentElement->firstChild;

				if ($node->hasAttribute('style')) {
					$styles = $node->getAttribute('style');
					$styles = self::removeBlacklistedProperties( $styles );
					$node->setAttribute('style', $styles);
				}

				$infoboxContainer = $dom->createElement('div');
				$infoboxContainer->setAttribute( 'id', 'infoboxContainer' );
				$infoboxContainer->setAttribute( 'class', 'infobox-container' );

				$infoboxContainer->appendChild($node);
				$body->insertBefore($infoboxContainer, $body->firstChild);

				$content = $dom->saveHTML();

				$parser->getOutput()->addModules( 'ext.wikia.venus.article.infobox' );
			}
		}

		return true;
	}

	/**
	 * Check if section content is first section in article and contain 'infobox' in class attribute
	 *
	 * @param Parser $parser Parser instance
	 * @param integer $section number of section in article text
	 * @param string $content section content
	 * @return bool
	 */
	static public function isInfoboxInFirstSection( $parser, $section, $content ) {
		return $parser->mIsMainParse && $section == 0 && stripos($content, self::INFOBOX_CLASS_NAME);
	}

	/**
	 * Remove blacklisted style properties from inline styles string
	 *
	 * @param string $styles
	 * @return string
	 */
	static public function removeBlacklistedProperties( $styles ) {
		$stylesArray = self::getStylesArray( $styles );
		$stylesArray = self::removeStyleProperties( $stylesArray, self::$stylesBlacklist );

		$styles = implode( ';', $stylesArray );

		return $styles;
	}

	/**
	 * Convert inline styles string into array with property name as a key
	 *
	 * @param string $styles inline styles
	 * @return array
	 */
	static public function getStylesArray( $styles ) {
		$stylesArray = [];

		$styles = explode( ';', $styles );

		foreach ( $styles as $style ) {
			$styleProperty = explode( ':', $style );
			$stylesArray[trim($styleProperty[0])] = $style;
		}

		return $stylesArray;
	}

	/**
	 * Remove blacklisted style properties from given array with styles
	 *
	 * @param array $stylesArray array with styles
	 * @param array $stylesBlacklist array with blacklisted properties
	 * @return mixed
	 */
	static public function removeStyleProperties($stylesArray, $stylesBlacklist ) {
		if ( is_array( $stylesBlacklist ) ) {
			foreach ( $stylesBlacklist as $styleName ) {
				if ( isset( $stylesArray[ $styleName ] ) ) {
					unset( $stylesArray[ $styleName ] );
				}
			}
		}

		return $stylesArray;
	}
}
