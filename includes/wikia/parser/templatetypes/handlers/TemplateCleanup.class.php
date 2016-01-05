<?php

class TemplateCleanup {

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
			$headers = [ 'h6', 'h5', 'h4', 'h3', 'h2', 'h1' ];
			foreach ( $headers as $h ) {
				$hs = $xpath->query( "//{$h}" );
				for ( $i = 0; $i < $hs->length; $i++ ) {
					$current = $hs->item( $i );
					//skip empty text nodes (spaces and new lines)
					$next = $current->nextSibling;
					while ( $next && $next->nodeType == XML_TEXT_NODE && empty( trim( $next->nodeValue ) ) ) {
						$next = $next->nextSibling;
					}
					//remove if next node is header of same or higher level, or last node
					if ( in_array( $next->nodeName, $headers ) && $current->nodeName[ 1 ] >= $next->nodeName[ 1 ]
						 || $next === null
					) {
						$current->parentNode->removeChild( $current );
					}
				}
			}

			$html = HtmlHelper::getBodyHtml( $dom );
		}
		wfProfileOut( __METHOD__ );

		return true;
	}

	private static function shouldBeProcessed() {
		global $wgEnableEmptySectionsCleanup, $wgArticleAsJson;

		return $wgEnableEmptySectionsCleanup && $wgArticleAsJson;
	}

}
