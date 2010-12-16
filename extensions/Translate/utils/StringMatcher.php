<?php
interface StringMangler {
	public static function EmptyMatcher();
	public function setConf( $configuration );

	// String or array
	public function match( $string );
	public function mangle( $data );
	public function unMangle( $data );
}


class StringMatcher implements StringMangler {
	protected $sPrefix = '';
	protected $aExact  = array();
	protected $aPrefix = array();
	protected $aRegex  = array();

	public static function EmptyMatcher() {
		return new StringMatcher;
	}

	public function __construct( $prefix = '', $patterns = array() ) {
		$this->sPrefix = $prefix;
		$this->init( $patterns );
	}

	public function setConf( $conf ) {
		$this->sPrefix = $conf['prefix'];
		$this->init( $conf['patterns'] );
	}

	protected function init( Array $strings ) {
		foreach ( $strings as $string ) {
			$pos = strpos( $string, '*' );
			if ( $pos === false ) {
				$this->aExact[] = $string;
			} elseif ( $pos + 1 === strlen( $string ) ) {
				$prefix = substr( $string, 0, - 1 );
				$this->aPrefix[$prefix] = strlen( $prefix );
			} else {
				$string = str_replace( '\\*', '.+', preg_quote( $string ) );
				$this->aRegex[] = "/^$string$/";
			}
		}
	}

	public function match( $string ) {
		if ( in_array( $string, $this->aExact ) ) return true;

		foreach ( $this->aPrefix as $prefix => $len ) {
			if ( strncmp( $string, $prefix, $len ) === 0 ) return true;
		}

		foreach ( $this->aRegex as $regex ) {
			if ( preg_match( $regex, $string ) ) return true;
		}

		return false;
	}

	public function mangle( $data ) {
		if ( !$this->sPrefix ) { return $data; }
		if ( is_array( $data ) ) {
			return $this->mangleArray( $data );
		} elseif ( is_string( $data ) ) {
			return $this->mangleString( $data );
		} elseif ( $data === null ) {
			return $data;
		} else {
			throw new MWException( __METHOD__ . ": Unsupported datatype" );
		}
	}

	public function unMangle( $data ) {
		if ( !$this->sPrefix ) { return $data; }
		if ( is_array( $data ) ) {
			return $this->mangleArray( $data, true );
		} elseif ( is_string( $data ) ) {
			return $this->mangleString( $data, true );
		} elseif ( $data === null ) {
			return $data;
		} else {
			throw new MWException( __METHOD__ . ": Unsupported datatype" );
		}
	}


	protected function mangleString( $string, $reverse = false ) {
		if ( $reverse ) {
			return $this->unMangleString( $string );
		} elseif ( $this->match( $string ) ) {
			return $this->sPrefix . $string;
		} else {
			return $string;
		}
	}

	protected function unMangleString( $string ) {
		if ( strncmp( $string, $this->sPrefix, strlen( $this->sPrefix ) ) === 0 ) {
			return substr( $string, strlen( $this->sPrefix ) );
		} else {
			return $string;
		}
	}

	protected function mangleArray( Array $array, $reverse = false ) {
		$temp = array();

		if ( isset( $array[0] ) ) {
			foreach ( $array as $key => &$value ) {
				$value = $this->mangleString( $value, $reverse );
				$temp[$key] = $value; // Assign a reference
			}
		} else {
			foreach ( $array as $key => &$value ) {
				$key = $this->mangleString( $key, $reverse );
				$temp[$key] = $value; // Assign a reference
			}
		}

		return $temp;
	}
}
