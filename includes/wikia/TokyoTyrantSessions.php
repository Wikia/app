<?

if ( !defined( 'MEDIAWIKI' ) ) {
	die( "This file is part of MediaWiki, it is not a valid entry point" );
}

require_once dirname(__FILE__) . "/../../lib/Tyrant.php";

#ttserver -port 1979 -ext /path/to/expire.lua -extpc expire 1.0 '/tmp/sessions.tct#idx=key:lex#idx=x:dec#idx=val:lex#dfunit=8'
# where 
#  * key: string (wikicities:session:md5) - primary key
#  * x: decimal (number of seconds) - use to remove expire keys from table
#  * val: string (data)  
#
# master-master replication
# ttserver -port 1979 -ulog ulog-2 -sid 2 -mhost localhost -mport 1978 -rts 2.rts -ext /path/to/expire.lua -extpc expire 1.0 '/tmp/sessions.tct#idx=key:lex#idx=x:dec#idx=val:lex#dfunit=8'
#


class TokyoTyrantSession {
	const SESS_EXPIRE	= 100; #3600;
	const V_COLUMN		= 'val';
	const X_COLUMN		= 'x';
	const KEY_COLUMN	= 'key';
	const NBR_CONN		= 20;

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
		error_log("key = $key \n");
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

	private function connect($key) {
		if ( !$this->active ) {
			return false;
		}

		$conn = self::isConnected();
		if ( $conn ) {
			error_log ("sock: " . @$conn->socket() . "\n");
			return $conn;
		}
		error_log ("no connection: \n");
		
		if ( strpos($key, ' ') ) {
			error_log( __METHOD__ . ": found a space character in the key '".$key."'. Fixing it" );
			$key = str_replace( ' ', '_', $key );
		}

		$hv = is_array($key) ? intval($key[0]) : $this->hashfunc($key);
		$realkey = is_array($key) ? $key[1] : $key;

		for ($tries = 0; $tries < self::NBR_CONN; $tries++ ) {
			$this->cid = $hv % $this->active;
			list ( $this->host, $this->port ) = explode( ":", $this->servers[$this->cid] );
			if ( $this->host && $this->port ) {
				try {
					error_log ("connect: $this->host, $this->port, $this->cid \n");
					$TT = Tyrant::connect($this->host, $this->port, $this->cid);
					if ( $TT ) {
						$sock = $TT->socket();
						error_log ("TT->socket = " . print_r($sock, true));
						self::$sess_conn[$sock] = array($this->host, $this->port, $this->cid);
						return $TT;
					}
				} catch (Tyrant_Exception $e) {
					echo "cannot connect to TTserver ({$this->host}, {$this->port}, {$this->cid}) - " . $e->getMessage() . "\n";
				}
			}
			$hv = $this->hashfunc( $hv . $realkey );
		}
		return false;
	}	
	
	public static function close() {
		$conn = self::isConnected();
		error_log( __METHOD__ . ": sock: " . @$conn->socket() ."\n");
		/*
		if ( $conn ) {
			$sock = $conn->socket();
			error_log ( __METHOD__ . ": sock = " .print_r( $sock, true) );
			if ( isset(self::$sess_conn[$sock]) ) {
				list($host, $port, $cid) = self::$sess_conn[$sock]; 
				if ( $host && $port && $cid ) {
					$conn->disconnect($host, $port, $cid);
				}
				unset(self::$sess_conn[$sock]);
			}
		}*/
		return true;
	}
	
	public static function put( $key, $value ) {
		error_log (__METHOD__ . "($key)");
		$TT = TokyoTyrantSession::newFromKey($key);
		if ( $TT ) {
			$values = array(
				self::V_COLUMN => $value,
				self::X_COLUMN => time() + self::SESS_EXPIRE
			);
			return $TT->put($key, $values);
		}
		return false;
	}
	
	public static function get( $key ) {
		error_log (__METHOD__ . "($key)");
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
		error_log (__METHOD__ . "($key)");
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
		return self::get( self::get_key($id) ); 
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

session_set_save_handler(
	array('TokyoTyrantSession','__open'), 
	array('TokyoTyrantSession','__close'),
	array('TokyoTyrantSession','__read'),
	array('TokyoTyrantSession','__write'),
	array('TokyoTyrantSession','__destroy'),
	array('TokyoTyrantSession','__gc')
);

