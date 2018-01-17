<?php

class HtmlHelper {

	// source: https://developer.mozilla.org/en-US/docs/Web/HTML/Block-level_elements
	const BLOCK_ELEMENTS = [
		'address',
		'article',
		'aside',
		'blockquote',
		'canvas',
		'dd',
		'div',
		'dl',
		'dt',
		'fieldset',
		'figcaption',
		'figure',
		'footer',
		'form',
		'h1',
		'h2',
		'h3',
		'h4',
		'h5',
		'h6',
		'header',
		'hgroup',
		'hr',
		'li',
		'main',
		'nav',
		'noscript',
		'ol',
		'output',
		'p',
		'pre',
		'section',
		'table',
		'tfoot',
		'ul',
		'video',
	];

	/**
	 * Creates properly encoded DOMDocument. Silent loadHTML errors
	 * as libxml treats for example <figure> as invalid tag
	 *
	 * @param $html
	 *
	 * @return DOMDocument
	 */
	public static function createDOMDocumentFromText( $html ) {
		$error_setting = libxml_use_internal_errors( true );
		$document = new DOMDocument();

		if ( !empty( $html ) ) {
			//encode for correct load
			$document->loadHTML( mb_convert_encoding( $html, 'HTML-ENTITIES', 'UTF-8' ) );
		}

		// clear user generated html parsing errors
		libxml_clear_errors();
		libxml_use_internal_errors( $error_setting );

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

	public static function getNodeHtml( DOMDocument $document, DOMNode $node ) {
		// strip <html> and <body> tags
		$result = [ ];
		for ( $i = 0; $i < $node->childNodes->length; $i++ ) {
			$result[] = $document->saveHTML( $node->childNodes->item( $i ) );
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

	/**
	 * Removes wrapping node
	 * eg.: "<div><p>test</p> <a>more test</a></div>" -> "<p>test</p> <a>more test</a>"
	 *
	 * @param DOMNode $node
	 * @return DOMNode removed node
	 */
	public static function unwrapNode( DOMNode $node ) {
		$previousNode = $node;
		$currentLastChild = $node->lastChild;
		while ( $currentLastChild !== null ) {
			$previousNode = $node->parentNode->insertBefore( $currentLastChild, $previousNode );
			$currentLastChild = $node->lastChild;
		}
		return HtmlHelper::removeNode( $node );
	}

	/**
	 * Strips given attributes from HTML string
	 * For example it can convert `<a style="color: black">1</a>` to `<a>1</a>`
	 *
	 * @param string $html
	 * @param array $attribs
	 *
	 * @return string
	 */
	public static function stripAttributes( $html, $attribs ) {
		$dom = new simple_html_dom();
		$dom->load( $html );

		foreach ( $attribs as $attrib ) {
			foreach ( $dom->find( "*[$attrib]" ) as $e ) {
				$e->$attrib = null;
			}
		}

		$dom->load( $dom->save() );

		$domStripped = $dom->save();

		// simple_html_dom leaks memory and this is the way to fix it
		// @see http://stackoverflow.com/a/18090273/1050577
		// @see XW-1093
		$dom->clear();
		unset( $dom );

		return $domStripped;
	}

	public static function renameNode( DOMElement $node, string $newName ) {
		$newnode = $node->ownerDocument->createElement($newName);
		for($i = 0; $i < $node->childNodes->length; $i++) {
			$child = $node->childNodes->item($i);
			$child = $node->ownerDocument->importNode($child, true);
			$newnode->appendChild($child);
		}
		foreach ($node->attributes as $attrName => $attrNode) {
			$newnode->setAttribute($attrName, $attrNode->nodeValue);
		}
		$node->parentNode->replaceChild($newnode, $node);

		return $newnode;
	}
}
