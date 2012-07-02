<?php

/**
 * Abstract base class for translation memory (TM) parsers.
 *
 * @since 0.4
 *
 * @file LT_TMParser.php
 * @ingroup LiveTranslate
 *
 * @licence GNU GPL v3
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
abstract class LTTMParser {
	
	/**
	 * Creates a new translation memory parser.
	 * 
	 * @since 0.4
	 */
	public function __construct() {
		
	}
	
	/**
	 * Parses the provided text to a LTTranslationMemory object.
	 * 
	 * @since 0.4
	 * 
	 * @param string $text
	 * 
	 * @return LTTranslationMemory
	 */
	public abstract function parse( $text );
	
	/**
	 * Retruns a new instance of a parser that implements LTTMParser and can parse
	 * translation memories of the provided type. If none is found, an exception is thrown.
	 * 
	 * @since 0.4
	 * 
	 * @param string $tmType
	 * 
	 * @return LTTMParser
	 */
	public static function newFromType( $tmType ) {
		switch ( $tmType ) {
			case TMT_LTF :
				return new LTLTFParser();
				break;
			case TMT_TMX :
				return new LTTMXParser();
				break;
			case TMT_GCSV :
				return new LTGCSVParser();
				break;
			default :
				throw new MWException( "There is no translation memory parser for translation memories of type '$tmType'." );
		}		
	}
	
}
