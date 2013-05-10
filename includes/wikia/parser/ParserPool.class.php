<?php

/**
 * ParserPool maintains a pool of Parser instances that may be helpful
 * when you would normally use $wgParser, but you don't want to pollute
 * a global state or $wgParser may be in the middle of parsing.
 *
 * Use parse() if you don't need to configure Parser instance too much.
 *
 * Use get() and then release() if you have to book the Parser instance
 * for longer time.
 *
 * @author Władysław Bodzek <wladek@wikia-inc.com>
 */
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
		# Create base instance for cloning
		if ( self::$origin === null ) {
			$class = $wgParserConf['class'];
			if ( $class == 'Parser_DiffTest' ) {
				self::$origin = false;
			} else {
				self::$origin = new Parser( $wgParserConf );
			}
		}
		# Clone it (or create a new one if not possible)
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
	 * Don't forget to return the instance back to the pool using release()
	 * after you're done with your job.
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
	 * Return a Parser instance to the pool
	 *
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
		if ( count( $args ) >= 5 ) { // always set $clearState to true
			$args[4] = true;
		}

		$parser = self::get();
		$result = call_user_func_array( array( $parser, 'parse' ), $args );
		self::release($parser);

		return $result;
	}

	/**
	 * Expand templates and variables in the text, producing valid, static wikitext.
	 * Also removes comments.
	 *
	 * @return string
	 */
	public static function preprocess( $text, Title $title, ParserOptions $options, $revid = null ) {
		$args = func_get_args();

		$parser = self::get();
		$result = call_user_func_array( array( $parser, 'preprocess' ), $args );
		self::release($parser);

		return $result;
	}

}