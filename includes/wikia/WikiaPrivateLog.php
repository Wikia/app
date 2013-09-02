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
		global $wgDisablePrivateLog,
			$wgPrivateLogWikisBlacklist,
			$wgDBname,
			$wgServer;

		$this->name = "{$canonicalName}-WIKIA";
		$this->disabled = ( ( isset( $wgDisablePrivateLog ) &&
			( $wgDisablePrivateLog === true ||
			  ( is_array( $wgDisablePrivateLog ) &&
				!empty( $wgDisablePrivateLog[ $canonicalName ] ) ) ) ) ||
			( isset( $wgPrivateLogWikisBlacklist ) &&
			  is_array( $wgPrivateLogWikisBlacklist ) &&
			  in_array( $wgDBname, $wgPrivateLogWikisBlacklist ) ) );

		if ( isset( $_SERVER['REQUEST_URI'] ) ) {
			$this->uri = "{$wgServer}{$_SERVER['REQUEST_URI']}";
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
				$msg = json_encode( $this->processArray( $arg ) );
			} elseif ( is_object( $arg) ) {
				if ( $arg instanceof FileBackend ) {
					$msg = $arg->getName() . ( $arg->isReadOnly() ? ' (read-only: ' . $arg->getReadOnlyReason() . ')' : '' );
				} else {
					$msg = get_class( $arg );
				}
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
	 * Simplifies the representation of arrays for logging
	 *
	 * @param Array $items The array to process
	 *
	 * @return Array The simplified representation
	 */
	private function processArray( Array $items ) {
		if ( empty( $items ) ) {
			return $items;
		}

		$results = [];

		foreach ( $items as $item ) {
			if ( is_array( $item ) ) {
				$results[] = json_encode( $item );
			} elseif ( is_scalar( $item ) ) {
				$results[] = $item;
			} elseif ( $item instanceof FileOp ) {
				$x = ['type' => get_class( $item )];

				foreach( [
					'op',
					'content',
					'src',
					'dst',
					'overwrite',
					'overwriteSame',
					'ignoreMissingSource'
				] as $param ){
					$x[$param] = $item->getParam( $param );
				}

				$results[] = $x;
			} else {
				$results[] = gettype( $item );
			}
		}

		return $results;
	}
}