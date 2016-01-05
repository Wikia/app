<?php

class HtmlHelper {

	public static function createDOMDocumentFromText( $html ) {
		$document = new DOMDocument();
		//encode for correct load
		$document->loadHTML( mb_convert_encoding( $html, 'HTML-ENTITIES', 'UTF-8' ) );
		// clear user generated html parsing errors
		libxml_clear_errors();

		return $document;
	}

	public static function getBodyHtml( DOMDocument $dom ) {
		// strip <html> and <body> tags
		$result = [ ];
		$body = $dom->getElementsByTagName( 'body' )->item( 0 );
		for ( $i = 0; $i < $body->childNodes->length; $i++ ) {
			$result[] = $dom->saveHTML( $body->childNodes->item( $i ) );
		}

		return implode( "", $result );
	}
}
