<?

if ( !defined( 'MEDIAWIKI' ) ) {
	die( "This file is part of MediaWiki, it is not a valid entry point" );
}

require_once( "$IP/lib/Tyrant.php" );

#ttserver -port 1979 -ext /path/to/expire.lua -extpc expire 1.0 '/tmp/sessions.tct#idx=key:lex#idx=x:dec#idx=val:lex#dfunit=8'
# where
#  * key: string (wikicities:session:md5) - primary key
#  * x: decimal (number of seconds) - use to remove expire keys from table
#  * val: string (data)
#
# master-master replication
# ttserver -port 16666 -pid /tmp/ttserver.pid -sid 666  -ulog /tmp/ulog/ -ulim 1000000
#			-mhost 10.10.10.163 -mport 11212 -rts /tmp/2.rts
#			-ext /path/to/expire.lua -extpc expire 1.0
#			'/tmp/sessions.tct#idx=key:lex#idx=x:dec#idx=val:lex#dfunit=8'
#


class TokyoTyrantSession {
	const SESS_EXPIRE	= 3600;
	const V_COLUMN		= 'val';
	const X_COLUMN		= 'x';
	const KEY_COLUMN	= 'key';
	const NBR_CONN		= 20;

	private $mDebug = false;

	var $servers = null;
	var $active = 0;

	var $cid = null;
	var $host = "";
	var $port = "";

	public static $sess_conn = array();

	function __construct($servers = null) {
		$this->set_servers($servers);
	}

	public static function isConnected() {
		return Tyrant::getConnection();
	}

	public static function newFromKey($key) {
		global $wgSessionTTServers;
		$TTSess = new TokyoTyrantSession();
		$TTSess->set_servers($wgSessionTTServers);
		return $TTSess->connect($key);
	}

	public function set_servers($servers = null) {
		$this->servers = $servers;
		$this->active = count($servers);
	}

	public static function get_key($key) {
		global $wgSharedDB, $wgDBname, $wgWikiaCentralAuthDatabase;
		if ( !empty( $wgWikiaCentralAuthDatabase ) ) {
			$key = "{$wgWikiaCentralAuthDatabase}:session:{$key}";
		} elseif ( !empty( $wgSharedDB ) ) {
			$key = "{$wgSharedDB}:session:{$key}";
		} else {
			$key = "{$wgDBname}:session:{$key}";
		}
		return $key;
	}

	# functions c&p from memcached-client.php
	private function hashfunc($key) {
		return hexdec(substr(md5($key),0,8)) & 0x7fffffff;
	}

	public function connect($key) {
		if ( !$this->active ) {
			return false;
		}

		/*$conn = self::isConnected();
		if ( $conn ) {
			return $conn;
		}*/

		if( strpos($key, ' ') ) {
			Wikia::log( __METHOD__, "info", "found a space character in the key '".$key."'. Fixing it", $this->mDebug );
			$key = str_replace( ' ', '_', $key );
		}

		$hv = is_array($key) ? intval($key[0]) : $this->hashfunc($key);
		$realkey = is_array($key) ? $key[1] : $key;

		for ($tries = 0; $tries < self::NBR_CONN; $tries++ ) {
			$this->cid = $hv % $this->active;
			list ( $this->host, $this->port ) = explode( ":", $this->servers[$this->cid] );
			if ( $this->host && $this->port ) {
				try {
					$TT = Tyrant::connect($this->host, $this->port, $this->cid);
					if ( $TT ) {
						$sock = $TT->socket();
						self::$sess_conn[$sock] = array($this->host, $this->port, $this->cid);
						#Wikia::log( __METHOD__, "info", "Connected to TTserver ({$this->host}, {$this->port}, {$this->cid})", $this->mDebug );
						return $TT;
					}
				} catch (Tyrant_Exception $e) {
					Wikia::log( __METHOD__, "info", "cannot connect to TTserver ({$this->host}, {$this->port}, {$this->cid}) - " . $e->getMessage(), $this->mDebug );
				}
			}
			$hv = $this->hashfunc( $hv . $realkey );
		}
		return false;
	}

	public static function close() {
		$conn = self::isConnected();
		if ( $conn ) {
			$sock = $conn->socket();
			if ( isset(self::$sess_conn[$sock]) ) {
				list($host, $port, $cid) = self::$sess_conn[$sock];
				if ( $host && $port && $cid ) {
					$conn->disconnect($host, $port, $cid);
				}
				unset(self::$sess_conn[$sock]);
			}
		}
		return true;
	}

	public static function put( $key, $value ) {
		$TT = TokyoTyrantSession::newFromKey($key);
		if ( $TT ) {
			if ( !empty($value) ) {
				$values = array(
					self::V_COLUMN => $value,
					self::X_COLUMN => time() + self::SESS_EXPIRE
				);
				return $TT->put($key, $values);
			}
		}
		return false;
	}

	public static function read( $key ) {
		$TT = TokyoTyrantSession::newFromKey($key);
		if ( $TT ) {
			$result = $TT->get($key);
			if ( is_array( $result ) && isset( $result[self::V_COLUMN] ) ) {
				return $result[self::V_COLUMN];
			}
		}
		return '';
	}

	public static function out( $key ) {
		$TT = TokyoTyrantSession::newFromKey($key);
		if ( $TT ) {
			return $TT->out( $key );
		}
		return false;
	}

	# sessions functions
	public static function __open( $save_path, $session_name ) {
		return true;
	}
	public static function __close() {
		return self::close();
	}
	public static function __read( $id ) {
		return self::read( self::get_key($id) );
	}
	public static function __write( $id, $data ) {
		return self::put( self::get_key($id), $data );
	}
	public static function __destroy( $id ) {
		return self::out( self::get_key($id) );
	}
	public static function __gc( $maxlifetime ) {
		return true;
	}
}

class TokyoTyrantCache extends TokyoTyrantSession {
	public function set ($key, $value, $exp = 0) {
		if ( empty($exp) ) {
			$exp = getrandmax();
		} else {
			$exp = time() + $exp;
		}
		$TT = $this->connect($key);
		if ( $TT ) {
			if ( strlen($value) > 0 ) {
				$value = @serialize($value);
				$values = array(
					self::V_COLUMN => $value,
					self::X_COLUMN => $exp
				);
				return $TT->put($key, $values);
			} 
		}
		return true;
	}
	
	private function _get($key) {
		$value = $exp = 0;
		$TT = $this->connect($key);
		if ( $TT ) {
			$result = $TT->get($key);
			if ( is_array( $result ) && isset( $result[self::V_COLUMN] ) ) {
				$value = $result[self::V_COLUMN];
				$exp = $result[self::X_COLUMN];
			} 
		}
		return array($value, $exp);
	}
	
	public function get($key) {
		list ($value, $exp) = $this->_get($key);
		if ( $exp < time() ) {
			$value = null;
		} else {
			$value = @unserialize($value);
		}
		return $value;
	}
	
	public function decr ($key, $amt=1) {
		list ($value, $exp) = $this->_get($key);
		if ( $exp < time() ) {
			$value = null;
		} else {
			$value = @unserialize($value);
			if ( is_numeric($value) ) {
				$value = $value - intval($amt);
			} else {
				Wikia::log( __METHOD__, "info", "Invalid value" );
				$value = 0;
			}
			if ( $exp > time() ) {
				$exp = time() - $exp;
			}
			$this->set($key, $value, $exp );
		}
		return $value;
	}
	
	public function incr($key, $amt=1) {
		list ($value, $exp) = $this->_get($key);
		if ( $exp < time() ) {
			$value = null;
		} else {
			$value = @unserialize($value);
			if ( is_numeric($value) ) {
				$value = $value + intval($amt);
			} else {
				Wikia::log( __METHOD__, "info", "Invalid value" );
				$value = 0;
			}
			if ( $exp > time() ) {
				$exp = time() - $exp;
			}
			$this->set($key, $value, $exp );
		}
		return $value;
	}
	
	public function replace($key, $value, $exp = 0) {
		return $this->set($key, $value, $exp);
	}
	
	public function delete($key) {
		return self::out($key);
	}
}
