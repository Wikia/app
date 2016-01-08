<?php

class HtmlHelper {

	/**
	 * Creates properly encoded DOMDocument
	 *
	 * @param $html
	 *
	 * @return DOMDocument
	 */
	public static function createDOMDocumentFromText( $html ) {
		$document = new DOMDocument();
		//encode for correct load
		$document->loadHTML( mb_convert_encoding( $html, 'HTML-ENTITIES', 'UTF-8' ) );
		// clear user generated html parsing errors
		libxml_clear_errors();

		return $document;
	}

	/**
	 * Returns inner HTML of <body> tag as text
	 *
	 * @param DOMDocument $dom
	 *
	 * @return string
	 */
	public static function getBodyHtml( DOMDocument $dom ) {
		// strip <html> and <body> tags
		$result = [ ];
		$body = $dom->getElementsByTagName( 'body' )->item( 0 );
		for ( $i = 0; $i < $body->childNodes->length; $i++ ) {
			$result[] = $dom->saveHTML( $body->childNodes->item( $i ) );
		}

		return implode( "", $result );
	}

	/**
	 * Removes given node
	 *
	 * @param DOMNode $node
	 *
	 * @return DOMNode removed node
	 */
	public static function removeNode( DOMNode $node ) {
		return $node->parentNode->removeChild( $node );
	}

	/**
	 * Removes all given nodes
	 *
	 * @param array $nodes
	 *
	 * @return array list of removed nodes
	 */
	public static function removeNodes( Array $nodes ) {
		$output = [ ];
		/** @var DOMNode $node */
		foreach ( $nodes as $node ) {
			$output[] = self::removeNode( $node );
		}

		return $output;
	}
}
