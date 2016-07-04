<?php

class NavigationTemplate {

	private static $blockLevelElements = [
		'div',
		'table',
		'p',
	];

	const NAV_PATH = '//div[@data-navuniq]';
	const NESTED_NAV_PATH = '//div[@data-navuniq]//div[@data-navuniq]';

	public static function handle( $text ) {
		return !empty( $text ) ? self::mark( $text ) : $text;
	}

	public static function resolve( &$html ) {
		if ( $html ) {
			$html = self::process( $html );
		}
		return true;
	}

	/**
	 * @desc If a block element div, table or p is found in a template's text, return an empty
	 * string to hide the template.
	 * @param $html
	 *
	 * @return string
	 */
	private static function process( $html ) {
		$document = HtmlHelper::createDOMDocumentFromText( $html );
		$xpath = new DOMXPath( $document );
		$result = $xpath->query( self::NAV_PATH, $document );

		$blockElements = implode( "|", self::$blockLevelElements );
		for ( $i = 0; $i < $result->length; $i++ ) {
			$node = $result->item( $i );
			$found = $xpath->query( $blockElements, $node );
			if ( $found->length ) {
				HtmlHelper::removeNode( $node );
			} else {
				HtmlHelper::removeWrappingNode( $node );
			}
		}

		return HtmlHelper::getBodyHtml( $document );
	}

	/**
	 * Remove markings for nested templates
	 * @param $templateWikitext
	 * @return string
	 */
	public static function removeInnerMarks( $templateWikitext ) {
		$document = HtmlHelper::createDOMDocumentFromText( $templateWikitext );
		// check for nested navuniq divs
		$xpath = new DOMXPath( $document );
		$result = $xpath->query( self::NESTED_NAV_PATH, $document );
		if ( $result->length ) {
			for ( $i = 0; $i < $result->length; $i++ ) {
				$node = $result->item( $i );
				// implicitly remove new line from the string begining (see line: 72:51)
				$node->firstChild->nodeValue = substr( $node->firstChild->nodeValue, 1 );
				HtmlHelper::removeWrappingNode( $node );
			}

			return HtmlHelper::getBodyHtml( $document );
		}

		return $templateWikitext;
	}

	private static function mark( $text ) {
		return sprintf( "<div data-navuniq=\"%s\">\n%s</div>", uniqid(), $text );
	}
}
