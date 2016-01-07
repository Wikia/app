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
			$dom = HtmlHelper::createDOMDocumentFromText( $html );

			$xpath = new DOMXPath( $dom );
			foreach ( self::$headersList as $h ) {
				$hs = $xpath->query( "//{$h}" );
				for ( $i = 0; $i < $hs->length; $i++ ) {
					$current = $hs->item( $i );
					// skip empty text nodes (spaces and new lines)
					$emptySiblings = [ ];
					$next = $current->nextSibling;
					while ( self::isEmptyTextNode( $next ) ) {
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

			$html = HtmlHelper::getBodyHtml( $dom );
		}
		wfProfileOut( __METHOD__ );

		return true;
	}

	private static function shouldBeProcessed() {
		global $wgEnableMercuryHtmlCleanup, $wgArticleAsJson;

		return $wgEnableMercuryHtmlCleanup && $wgArticleAsJson;
	}

	private static function isEmptyTextNode( $next ) {
		return $next && $next->nodeType == XML_TEXT_NODE && empty( trim( $next->nodeValue ) );
	}

}
