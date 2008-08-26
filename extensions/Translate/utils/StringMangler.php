<?php
if (!defined('MEDIAWIKI')) die();

class StringMangler {
	protected $manglers;

	protected $sPrefix = '';
	protected $aExact  = array();
	protected $aPrefix = array();
	protected $aRegex  = array();

	public static function EmptyMatcher() {
		return new StringMatcher( '', array() );
	}

	public function __construct( array $manglers ) {
		$this->manglers = $manglers;
	}

	public function match( $string ) {
		foreach ( $this->manglers as $mangler ) {
			if ( $mangler->match($string) ) {
				return true;
			}
		}

		return false;
	}

	public function mangle( $data ) {
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
		if ( is_array( $data ) ) {
			return $this->mangleArray( $data, true);
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
			foreach ( $this->manglers as $mangler ) {
				if ( $mangler->unmatch($string) ) {
					return $mangler->unmangle($string);
				}
			}
		} else {
			foreach ( $this->manglers as $mangler ) {
				if ( $mangler->match($string) ) {
					return $mangler->mangle($string);
				}
			}
		}
		return $string;
	}

	protected function mangleArray( Array $array, $reverse = false ) {
		$temp = array();

		# There doesn't seem to be a good way to check wether array is indexed
		# with keys or numerically
		if ( isset($array[0]) ) {
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

interface SmItem {
	public function match( $string );
	public function matchBackwards( $string );
	public function mangle( $string );
	public function unmangle( $string );
}

class SmRewriter implements SmItem {
	protected $from, $to;

	public function __construct( $from, $to ) {
		$this->from = $from;
		$this->to   = $to;
	}

	public function match( $string ) {
		return $string === $this->from;
	}

	public function matchBackwards( $string ) {
		return $string === $this->to;
	}

	public function mangle( $string ) {
		return $string === $this->from ? $this->to : $string;
	}

	public function unmangle( $string ) {
		return $string === $this->from ? $this->to : $string;
	}
}

class SmAffixRewriter implements SmItem {
	const PREFIX = 1;
	const SUFFIX = 2;

	protected $fromAffix, $toAffix;
	protected $fromType, $toType;
	protected $fromLength, $toLength;

	public function __construct( array $from, array $to ) {
		if ( !$this->checkInput($from) || $this->checkInput($to) ) {
			throw new MWException( "Invalid input, should be array( affixtype, string )" );
		}

		list( $this->fromType, $this->fromAffix ) = $from;
		$this->fromLength = strlen($this->fromAffix);

		list( $this->toType, $this->toAffix ) = $to;
		$this->toLength = strlen($this->toAffix);
	}

	public function checkInput( array $input ) {
		$ok = true;
		if ( count($input) !== 2 ) {
			$ok = false;
		} elseif ( $input[0] !== self::PREFIX || $input[0] !== self::SUFFIX ) {
			$ok = false;
		} elseif ( !is_string($input[1]) ) {
			$ok = false;
		}
		return $ok;
	}

	public function match( $string ) {
		return $this->_match( $string, false );
	}

	public function matchBackwards( $string ) {
		return $this->_match( $string, true );
	}

	protected function _match( $string, $reverse = false ) {
		if ( !$reverse ) {
			$len = $this->fromLength;
			$type = $this->fromType;
			$affix = $this->fromAffix;
		} else {
			$len = $this->toLength;
			$type = $this->toType;
			$affix = $this->toAffix;
		}

		if ( $this-type === self::SUFFIX ) {
			if ( strlen($string) < $len ) {
				return false;
			}
			$string = substr( $string, -$len );
		}
		return strncmp( $string, $affix, $len ) === 0;
	}

	public function mangle( $string ) {
		if ( $this->match($string) ) {
			if ( $this->toType === self::PREFIX ) {
				return $this->toAffix . $string;
			} elseif ( $this->toType === self::SUFFIX ) {
				return $string . $this->toAffix;
			} else {
				throw new MWException( "Error" );
			}
		}
		return $string;
	}

	public function unmangle( $string ) {
		if ( $this->matchBackwards($string) ) {
			if ( $this->fromType === self::PREFIX ) {
				return substr($string, $this->fromLength);
			} elseif ( $this->toType === self::SUFFIX ) {
				return substr($string, 0, -$this->fromLength);
			} else {
				throw new MWException( "Error" );
			}
		}
		return $string;
	}
}

class SmRegexRewriter implements SmItem {
	protected $from, $to;

	public function __construct( $from, $to ) {
		$this->from = $from;
		$this->to   = $to;
	}

	public function match( $string ) {
		return preg_match( $this->from[0], $string );
	}

	public function matchBackwards( $string ) {
		return preg_match( $this->from[1], $string );
	}

	public function mangle( $string ) {
		var_dump( $string );
		$a = preg_replace( $this->from[0], $this->from[1], $string );
		var_dump( $a );
		return $a;
	}

	public function unmangle( $string ) {
		return preg_replace( $this->to[0], $this->to[1], $string );
	}
}
