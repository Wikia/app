<?php

class ParserPool {

	protected static $origin = null;
	protected static $pool = array();

	/**
	 * Create a new Parser object
	 *
	 * @return Parser
	 */
	public static function create() {
		global $wgParserConf;
		if ( self::$origin === null ) {
			# Clone it and store it
			$class = $wgParserConf['class'];
			if ( $class == 'Parser_DiffTest' ) {
				self::$origin = false;
			} else {
				self::$origin = new Parser( $wgParserConf );
			}
		}
		if ( self::$origin !== false ) {
			$parser = clone self::$origin;
		} else {
			$parser = new Parser( $wgParserConf );
		}
		return $parser;
	}

	/**
	 * Get a Parser instance from the pool
	 *
	 * @return Parser
	 */
	public static function get() {
		if ( !empty( self::$pool ) ) {
			$parser = array_shift( self::$pool );
		} else {
			$parser = self::create();
			$parser->isFromParserPool = true;
		}
		return $parser;
	}

	/**
	 * Return a Parser instane to the pool
	 * @param Parser $parser
	 */
	public static function release( Parser $parser ) {
		if ( !empty( $parser->isFromParserPool ) ) {
			self::$pool[] = $parser;
		}
	}

	/**
	 * Convert wikitext to HTML
	 *
	 * @return ParserOutput
	 */
	public static function parse( $text, Title $title, ParserOptions $options, $linestart = true, $clearState = true, $revid = null ) {
		$args = func_get_args();
		if ( isset( $args[4] ) ) { // always set $clearState to true
			$args[4] = true;
		}

		$parser = self::get();
		$result = call_user_func_array( array( $parser, 'parse' ), $args );
		self::release($parser);

		return $result;
	}

}