<?php
/**
 * Temporary logging facility for BAC-691, please do not reuse, it will be
 * removed when the investigation will be over
 *
 * @author: Moli <moli@wikia-inc.com>
 * @author: Federico "Lox" Lucignano <federico@wikia-inc.com>
 */
use \Wikia as W;

class WikiaPrivateLog {
	private static $channels = [];
	private $name = '';
	private $disabled = true;
	private $uri = '';

	/**
	 * Gets a private log channel by name
	 *
	 * @param string $channelName The name of the log channel, it will be created
	 * if it doesn't exist
	 *
	 * return WikiaPrivateLog The log channel instance
	 */
	public static function getChannel( $channelName ) {
		$canonicalName = is_null( $channelName ) ? '*' : strtoupper( $channelName );

		if ( array_key_exists( $canonicalName, self::$channels ) ) {
			$channel = self::$channels[$canonicalName];
		} else {
			self::$channels[$canonicalName] = $channel = new self( $canonicalName );
		}

		return $channel;
	}

	/**
	 * Creates a private log channel
	 *
	 * @param string $canonicalName The canonical (uppercase) name for the
	 * log channel
	 */
	public function __construct( $canonicalName = '*' ) {
		global $wgDisablePrivateLog;

		$this->name = "{$canonicalName}-WIKIA";
		$this->disabled = isset( $wgDisablePrivateLog ) &&
			( $wgDisablePrivateLog === true ||
			  ( is_array( $wgDisablePrivateLog ) &&
				!empty( $wgDisablePrivateLog[ $canonicalName ] ) ) );

		if ( isset( $_SERVER['REQUEST_METHOD'] ) &&
			 $_SERVER['REQUEST_METHOD'] === 'GET' &&
			 $_SERVER['SCRIPT_URL'] === '/wikia.php' ) {
			$this->uri = $_SERVER['REQUEST_URI'];
		}
	}

	/**
	 * Sends data to the log channel
	 *
	 * @param Varargs: parameters to log
	 *
	 * @return bool true for success, false for failure
	 */
	public function send( $args, $includeBacktrace = false ) {
		if ( $this->disabled ) {
			return false;
		}

		if ( !empty( $this->uri ) ) {
			W::log( $this->name, false, $this->uri, true /* $force */ );
		}

		if ( !is_array( $args ) ) {
			$args = [$args];
		}

		foreach ( $args as $arg ) {
			if ( is_scalar( $arg ) ) {
				$msg = $arg;
			} elseif (is_array( $arg ) ) {
				$msg = json_encode( $this->flattenArray( print_r( $arg, true ) ) );
			} else {
				$msg = gettype( $arg );
			}

			W::log( $this->name, false, $msg, true /* $force */ );
		}

		if ( $includeBacktrace === true ) {
			W::debugBacktrace( $this->name );
		}

		return true;
	}

	/**
	 * Flattens the textual representation of an array, either multidimensional
	 * or containing objects (includes the object's fields)
	 */
	private function flattenArray( $text ) {
		$output = [];
		$cleanText = preg_replace( '/\s+/', ' ', str_replace( "\n", ' ', $text ) );
		$array_contents = substr($cleanText, 7, -2);
		$array_contents = str_replace( ['[', ']', '=>'], ['#!#', '#?#', ''], $array_contents );
		$array_fields = explode( "#!#", $array_contents );

		for( $i = 0; $i < count($array_fields); $i++ ) {
			if( $i != 0 ) {
				$bits = explode( '#?#', $array_fields[$i] );
				if( $bits[0] != '' ) $output[$bits[0]] = $bits[1];
			}
		}

		return $output;
    }
}