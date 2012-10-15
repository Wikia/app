<?php

class Multilang {

	/**
	 * Alternative text blocks
	 * Index is the language code to which it corresponds
	 */
	private static $text = array();
	
	/**
	 * Fallback language
	 */
	private static $fallback = '';

	/**
	 * Register a new alternative text block
	 * (Handles the parser hook for <language></language>)
	 *
	 * @param $text Content
	 * @param $args Tag attributes
	 * @param $parser Parent parser
	 * @return string
	 */
	public static function languageBlock( $text, $args, $parser ) {
		if( isset( $args['lang'] ) ) {
			$lang = strtolower( $args['lang'] );
			self::$text[$lang] = $text;
			self::updateFallback( $lang );
		} else {
			# Disaster! We *have* to know the language code, otherwise
			# we have no idea when to show the text in question
		}
		return '';
	}
	
	/**
	 * Output the appropriate text block
	 * (Handles the parser hook for <multilang />)
	 *
	 * @param $text Content
	 * @param $args Tag attributes
	 * @param $parser Parent parser
	 * @return string
	 */
	public static function outputBlock( $text, $args, $parser ) {
		global $wgLang;
		# Cache is varied according to interface language...
		$lang = $wgLang->getCode();
		$text = self::getText( $lang );
		$output = $parser->parse( $text, $parser->getTitle(), $parser->getOptions(), true, false );
		return $output->getText();
	}
	
	/**
	 * Get the text block corresponding to the requested language code,
	 * or the fallback if needed
	 *
	 * @param $lang Language code
	 * @return string
	 */
	private static function getText( $lang ) {
		return isset( self::$text[$lang] ) ? self::$text[$lang] : self::getFallback();
	}
	
	/**
	 * Get the fallback text
	 *
	 * @return string
	 */
	private static function getFallback() {
		return isset( self::$text[self::$fallback] ) ? self::$text[self::$fallback] : '';
	}
	
	/**
	 * When a new text block is made available, look at the language
	 * code, and see if it's a better fallback than the one we have
	 *
	 * @param $lang Language code
	 */
	private static function updateFallback( $lang ) {
		global $wgContLang;
		if( self::$fallback == '' || $lang == $wgContLang->getCode() ) {
			self::$fallback = $lang;
		}
	}

	/**
	 * Set hooks on a Parser instance
	 */
	public static function onParserFirstCallInit( $parser ) {
		$parser->setHook( 'language', array( __CLASS__, 'languageBlock' ) );
		$parser->setHook( 'multilang', array( __CLASS__, 'outputBlock' ) );
		return true;
	}

	/**
	 * Clear all internal state information
	 */
	public static function clearState() {
		self::$text = array();
		self::$fallback = '';
		return true;
	}
	
}


