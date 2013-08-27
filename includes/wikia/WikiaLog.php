<?php

class WikiaLog {
	private $log = '';
	private $not_allowed = true;
	private $backtrace = false;
	private $url = '';
	
	public function __construct( $log, $not_allowed, $backtrace ) {
		$this->log = sprintf( "%s-WIKIA", strtoupper($log) );
		$this->not_allowed = $not_allowed;
		$this->backtrace = $backtrace;

		if (isset($_SERVER['REQUEST_METHOD']) && ($_SERVER['REQUEST_METHOD'] === 'GET') && ($_SERVER['SCRIPT_URL'] === '/wikia.php')) {
			$this->url = $_SERVER['REQUEST_URI'];
		}
	}
	
	static function init( $log = '', $backtrace = false ) {
		global $wgDisablePrivateLog;
		
		$log = strtolower( $log );
		$not_allowed = isset( $wgDisablePrivateLog ) && !empty( $wgDisablePrivateLog[ ( empty( $log ) ? '*' : $log ) ] );
		
		return new WikiaLog( $log, $not_allowed, $backtrace );
	}
	
	/*
	* @param Varargs: parameters as Strings
	*/
	public function send( /* ... */ ) {
		if ( $this->not_allowed ) {
			return false;
		}
		
		$numargs = func_num_args();
		if ( $numargs > 0 ) {
			$arg_list = func_get_args();
			# url first
			if ( !empty( $this->url ) ) {
				Wikia::log( $this->log, false, $this->url, true /* $force */ );
			}
			# rest logs
			for ( $i = 0; $i < $numargs; $i++ ) {
				if ( !is_string( $arg_list[ $i ] ) ) {
					$msg = json_encode( $this->_dump_to_text( print_r( $arg_list[ $i ], true ) ) );
				} else {
					$msg = $arg_list[ $i ];
				}
				Wikia::log( $this->log, false, $msg, true /* $force */ );
			}
			
			if ( $this->backtrace ) {
				Wikia::debugBacktrace( $this->log ); 
			}
		}
		
		return true;
	}
	
	function _dump_to_text( $str ) {
		$keys = $values = $output = array();

		$str = preg_replace( '/\\n/', ' ', $str );
		$str = preg_replace( '/\s+/', ' ', $str );

		if ( substr($str, 0, 5) == 'Array' ) {
			$array_contents = substr($str, 7, -2);
			$array_contents = str_replace( array('[', ']', '=>'), array('#!#', '#?#', ''), $array_contents );
			$array_fields = explode( "#!#", $array_contents );

			for( $i = 0; $i < count($array_fields); $i++ ) {
				if( $i != 0 ) {
					$bits = explode('#?#', $array_fields[$i]);
					if( $bits[0] != '' ) $output[$bits[0]] = $bits[1];
				}
			}
			return $output;
		} else {
			return null;
		}
    }
}
