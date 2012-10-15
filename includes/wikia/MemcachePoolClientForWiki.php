<?php

/**
 * @author Krzysztof Krzyżaniak (eloy) <eloy@wikia.com>
 * @copyright GPLv2
 *
 * @example:
 *
 * $wgMemCachedlServers = array(
 *     0 => array(
 *       "host" => "127.0.0.1",
 *       "port" => 11211,
 *       "weight" => 1,
 *       "persistent" => true,
 *       "timeout" => 1, *
 *	   )
 * );
 */

/**
 * it demands external extension to work so better safe than sorry
 */
if( class_exists("MemcachePool") ) {

	class MemcachePoolClientForWiki extends MemcachePool {

		const FLAGS = MEMCACHE_COMPRESSED;
		public $_persistant, $_debug;


		/**
		 * constructor
		 *
		 * @author eloy
		 * @access public
		 * @static
		 *
		 * @param array $params: parameters describing memcache object
		 *
		 * @return MemcachePoolClientForWiki object
		 */
		public function __construct( $params ) {
			if( isset( $params["debug"] ) ) {
				$this->_debug = $params["debug"];
			}

			if( isset( $params["servers"] ) ) {
				$this->set_servers( $params["servers"] );
			}
		}

		/**
		 * set_servers
		 *
		 * add servers to active servers
		 *
		 * @author eloy
		 * @access public
		 *
		 * @param mixed $servers: definition of servers
		 *
		 */
		public function set_servers( $servers ) {
			global $wgMemCachedPoolProtocol, $wgMemCachedPoolRedundancy;
			global $wgMemCachedPoolHashStrategy, $wgMemCachedPoolHashFunction;

			if( is_array( $servers ) ) {

				/**
				 * set some configuration directives before connect
				 */
				$protocol = in_array( $wgMemCachedPoolProtocol, array("binary", "ascii") )
					? $wgMemCachedPoolProtocol : "ascii";
				$redundancy = ( $wgMemCachedPoolRedundancy > 1 )
					? $wgMemCachedPoolRedundancy : 1;
				$strategy = in_array( $wgMemCachedPoolHashStrategy, array( "standard", "consistent" ) )
					? $wgMemCachedPoolHashStrategy : "consistent";
				$function = in_array( $wgMemCachedPoolHashFunction, array( "crc32", "fnv" ) )
					? $wgMemCachedPoolHashFunction : "crc32";

				ini_set( "memcache.protocol", $protocol );
				ini_set( "memcache.redundancy", $redundancy );
				ini_set( "memcache.hash_strategy", $strategy );
				ini_set( "memcache.hash_function", $function );

				foreach( $servers as $server ) {
					/**
					 * use configuration values or default
					 */
					$host = isset( $server["host"] )
						? $server["host"] : "127.0.0.1";
					$port = isset( $server["port"] )
						? $server["port"] : 11211;
					$weight = isset( $server["weight"] )
						? $server["weight"] : 1;
					$persistent = isset( $server["persistent"] )
						? (bool)$server["persistent"] : true;
					$timeout = isset( $server["timeout"] )
						? $server["timeout"] : 1;
					$this->addServer( $host, $port, 0, $persistent, $weight, $timeout );
					if( $this->_debug ) {
						wfDebug( __METHOD__.": connecting to {$host}:{$port} {$persistent} {$weight} {$timeout}\n" );
					}
				}
			}
			$this->setCompressThreshold( 1500 );
			$this->setFailureCallback( "memcachedPollCallback" );
		}

		/**
		 * set_debug
		 *
		 * set/unset debug flag. only for compatibility
		 *
		 * @author eloy
		 * @access public
		 * @param boolean $flag: set/unset debug flag
		 *
		 */
		public function set_debug( $flag ) {
			$this->_debug = $flag;
		}

		/**
		 * set_compress_threshold
		 *
		 * set/unset threshold value. Only for compatibility
		 *
		 * @author eloy
		 * @access public
		 *
		 * @param boolean $value: threshold value
		 *
		 */
		public function set_compress_threshold( $value ) {
			$this->setCompressThreshold( $value );
		}

		/**
		 * incr
		 *
		 * increment value of key
		 *
		 * @author eloy
		 * @access public
		 *
		 * @param string $key: key to increas
		 * @param integer $value default 1: amount to increment
		 *
		 * @return new value of key
		 */
		public function incr( $key, $value = 1 ) {
			return $this->increment( $key, $value, 0 );
		}

		/**
		 * decr
		 *
		 * decrement value of key
		 *
		 * @author eloy
		 * @access public
		 *
		 * @param string $key: key to increas
		 * @param integer $value default 1: amount to increment
		 *
		 * @return new value of key
		 */
		public function decr ( $key, $value = 1 ) {
			return $this->decrement( $key, $value, 0 );
		}

		/**
		 * add
		 *
		 * Adds a key/value to the memcache server if one isn't already set with
		 * that key
		 *
		 * @author eloy
		 * @access public
		 *
		 * @param   string   $key     Key to set value as
		 * @param   mixed    $value   Value to set
		 * @param   integer  $exp     (optional) Experiation time
		 *
		 * @return boolean: true if set successfully.
		 */
		public function add( $key, $value, $exptime = 0 ) {
			return parent::add( $key, $value, self::FLAGS, $exptime );
		}

		/**
		 * set
		 *
		 * sets a key to a given value in the memcache.
		 *
		 * @author eloy
		 * @access public
		 *
		 * @param   string   $key     Key to set value as
		 * @param   mixed    $value   Value to set
		 * @param   integer  $exp     (optional) Experiation time
		 *
		 * @return boolean: true if set successfully.
		 */
		public function set( $key, $value, $exptime = 0 ) {
			return parent::set( $key, $value, self::FLAGS, $exptime );
		}

		/**
		 * get
		 *
		 * get a value from the memcache.
		 *
		 * @author eloy
		 * @access public
		 *
		 * @param   string   $key     Key to get value
		 *
		 * @return mixed
		 */
		public function get( $key ) {
			$value = null;
			try {
				$value = parent::get( $key, self::FLAGS );
			}
			catch ( Exception $e ) {
				$value = null;
				wfDebugLog( "memcachepool", "Error when getting value from key {$key}", true );
			}
			if( $this->_debug ) {
				wfDebug( __METHOD__ . ": {$key} value is " . ( is_null( $value ) ? "null" : "not null") . "\n" );
			}
			return $value;
		}
	}

	function memcachedPollCallback( $host, $tcp_port, $udp_port, $error, $errnum ) {
		error_log( "memcachepool: {$host} {$tcp_port} {$udp_port} {$error} {$errnum}" );
	}

}
