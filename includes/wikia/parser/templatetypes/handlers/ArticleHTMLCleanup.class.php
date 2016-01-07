<?php

class ArticleHTMLCleanup {
	private static $headersList = [ 'h6', 'h5', 'h4', 'h3', 'h2', 'h1' ];

	/**
	 * This method will remove empty sections headers from article content
	 *
	 * @param $parser
	 * @param $html
	 *
	 * @return bool
	 */
	public static function doCleanup( $parser, &$html ) {
		wfProfileIn( __METHOD__ );

		if ( $html && static::shouldBeProcessed() ) {
			$html = self::processHtml( $html );
		}
		wfProfileOut( __METHOD__ );

		return true;
	}

	private static function shouldBeProcessed() {
		global $wgEnableMercuryHtmlCleanup, $wgArticleAsJson;

		return $wgEnableMercuryHtmlCleanup && $wgArticleAsJson;
	}

	private static function processHtml( $html ) {
		$dom = HtmlHelper::createDOMDocumentFromText( $html );

		$xpath = new DOMXPath( $dom );
		foreach ( self::$headersList as $h ) {
			$hs = $xpath->query( "//{$h}" );
			for ( $i = 0; $i < $hs->length; $i++ ) {
				$current = $hs->item( $i );
				// skip empty text nodes (spaces and new lines), br nodes and empty paragraphs
				$emptySiblings = [ ];
				$next = $current->nextSibling;
				while ( self::containsInvisibleElementsOnly( $next ) ) {
					$emptySiblings[] = $next;
					$next = $next->nextSibling;
				}
				// remove if next node is header of same or higher level, or a last node
				if ( ( in_array( $next->nodeName, self::$headersList )
					   && $current->nodeName[ 1 ] >= $next->nodeName[ 1 ] )
					 || $next === null
				) {
					// remove empty siblings as well
					HtmlHelper::removeNodes( array_merge( [ $current ], $emptySiblings ) );
				}
			}
		}

		return HtmlHelper::getBodyHtml( $dom );
	}

	/**
	 * @param DOMNode|null $node
	 *
	 * @return bool
	 */
	private static function isEmptyTextNode( $node ) {
		return $node && $node->nodeType == XML_TEXT_NODE && empty( trim( $node->nodeValue ) );
	}

	/**
	 * @param DOMNode|null $node
	 *
	 * @return bool
	 */
	private static function isEmptyParagraphNode( $node ) {
		if ( $node && $node->nodeType == XML_ELEMENT_NODE && $node->nodeName === 'p' ) {
			$result = true;
			/** @var DOMNode $child */
			for ( $i = 0; $i < $node->childNodes->length; $i++ ) {
				// all child nodes should be either empty text nodes, br nodes or empty paragraphs nodes
				$child = $node->childNodes->item( $i );
				$result &= self::containsInvisibleElementsOnly( $child );
			}

			return $result;
		}

		return false;
	}

	/**
	 * @param DOMNode|null $node
	 *
	 * @return bool
	 */
	private static function isBrNode( $node ) {
		return $node && $node->nodeType == XML_ELEMENT_NODE && $node->nodeName === 'br';
	}

	/**
	 * Check if node is empty or contains no visible elements
	 *
	 * @param $next
	 *
	 * @return bool
	 */
	private static function containsInvisibleElementsOnly( $next ) {
		return self::isEmptyTextNode( $next )
			   || self::isBrNode( $next )
			   || self::isEmptyParagraphNode( $next );
	}

}
