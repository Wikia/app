<?php

class ReferencesTemplate {
	/**
	 * @desc return simple <references /> parser tag if the original text contains it
	 * @param $text string
	 * @return string
	 */
	public static function handle( $text ) {
		$error_setting = libxml_use_internal_errors( true );

		$dom = new DOMDocument();
		$dom->loadHTML( '<body>' . $text . '</body>');
		$xpath = new DOMXPath($dom);
		$references = $xpath->query('//references');

		libxml_clear_errors();
		libxml_use_internal_errors( $error_setting );

		if ( $references->length > 0 ) {
			return '<references />';
		}

		return $text;
	}
}
