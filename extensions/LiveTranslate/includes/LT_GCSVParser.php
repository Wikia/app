<?php

/**
 * Parser for translation memory data in the Google CSV format (GCSV).
 *
 * @since 0.4
 *
 * @file LT_GCSVParser.php
 * @ingroup LiveTranslate
 *
 * @licence GNU GPL v3
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class LTGCSVParser extends LTTMParser {
	
	/**
	 * (non-PHPdoc)
	 * @see LTTMParser::parse()
	 */
	public function parse( $text ) {
		return new LTTranslationMemory(); // TODO
	}
	
}
