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

		if ( !array_key_exists( $canonicalName, self::$channels ) ) {
			self::$channels[$canonicalName] = new self( $canonicalName );
		}

		return self::$channels[$canonicalName];
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
				$msg = json_encode( $this->flattenArray( $arg ) );
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
	 * or containing objects (includes the object's fields), it's meant to allow
	 * serializing non-serializable structures used in the FileSystem stack.
	 *
	 * @example
	 * $a = [new DateTime(), new DateTime()];
	 * var_dump($a);
	 * >   array(2) {
	 * >       [0]=>
	 * >       object(DateTime)#1 (3) {
	 * >            ["date"]=> string(19) "2013-08-29 17:58:42 "
	 * >            ["timezone_type"]=> int(3)
	 * >            ["timezone"]=> string(13) "Europe/Warsaw"
	 *         }
	 * >       [1]=>
	 * >       object(DateTime)#2 (3) {
	 * >            ["date"]=> string(19) "2013-08-29 17:58:42"
	 * >            ["timezone_type"]=> int(3)
	 * >            ["timezone"]=> string(13) "Europe/Warsaw"
	 * >       }
	 * >   }
	 *
	 * After applying flattenArray:
	 * >   array(8) {
	 * >       [0]=>
	 * >       array(1) {
	 * >           [0]=> string(20) "  DateTime Object ( "
	 * >       }
	 * >       [1]=>
	 * >       array(1) {
	 * >           ["date"]=> string(22) "  2013-08-29 18:15:44 "
	 * >       }
	 * >       [2]=>
	 * >       array(1) {
	 * >           ["timezone_type"]=> string(4) "  3 "
	 * >       }
	 * >       [3]=>
	 * >       array(1) {
	 * >           ["timezone"]=> string(18) "  Europe/Warsaw ) "
	 * >       }
	 * >       [4]=>
	 * >       array(1) {
	 * >           [1]=> string(20) "  DateTime Object ( "
	 * >       }
	 * >       [5]=>
	 * >       array(1) {
	 * >           ["date"]=> string(22) "  2013-08-29 18:15:44 "
	 * >       }
	 * >       [6]=>
	 * >       array(1) {
	 * >           ["timezone_type"]=> string(4) "  3 "
	 * >       }
	 * >       [7]=>
	 * >       array(1) {
	 * >           ["timezone"]=> string(18) "  Europe/Warsaw ) "
	 * >       }
	 * >   }
	 */
	private function flattenArray( Array $data ) {
		$output = [];
		$cleanText = preg_replace( '/\s+/', ' ', str_replace( "\n", ' ', print_r( $data, true ) ) );
		$array_contents = substr( $cleanText, 7, -2 );
		$array_contents = str_replace( ['[', ']', '=>'], ['#!#', '#?#', ''], $array_contents );
		$array_fields = explode( "#!#", $array_contents );

		for ( $i = 0; $i < count($array_fields); $i++ ) {
			if ( $i != 0 ) {
				$bits = explode( '#?#', $array_fields[$i] );

				if ( $bits[0] != '' ) {
					$output[] = [$bits[0] => $bits[1]];
				}
			}
		}

		return $output;
	}
}