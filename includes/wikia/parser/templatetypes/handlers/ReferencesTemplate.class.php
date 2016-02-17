<?php

class ReferencesTemplate {
	/**
	 * @desc return simple <references /> parser tag if the original text contains it
	 * @param $text string
	 * @return string
	 */
	public static function handle( $text ) {
		$dom = HtmlHelper::createDOMDocumentFromText( $text );
		$xpath = new DOMXPath( $dom );
		$references = $xpath->query( '//references' );

		if ( $references->length > 0 ) {
			return '<references />';
		}

		return $text;
	}
}
