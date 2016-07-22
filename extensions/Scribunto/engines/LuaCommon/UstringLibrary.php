<?php

class Scribunto_LuaUstringLibrary extends Scribunto_LuaLibraryBase {
	/**
	 * Limit on pattern lengths, in bytes not characters
	 * @var integer
	 */
	private $patternLengthLimit = 10000;

	/**
	 * Limit on string lengths, in bytes not characters
	 * If null, $wgMaxArticleSize * 1024 will be used
	 * @var integer|null
	 */
	private $stringLengthLimit = null;

	/**
	 * PHP 5.3's mb_check_encoding does not reject characters above U+10FFFF.
	 * When using that version, we'll need to check that manually.
	 * @var boolean
	 */
	private $manualCheckForU110000AndUp = false;

	function __construct( $engine ) {
		if ( $this->stringLengthLimit === null ) {
			global $wgMaxArticleSize;
			$this->stringLengthLimit = $wgMaxArticleSize * 1024;
		}

		$this->manualCheckForU110000AndUp = mb_check_encoding( "\xf4\x90\x80\x80", "UTF-8" );

		parent::__construct( $engine );
	}

	function register() {
		$perf = $this->getEngine()->getPerformanceCharacteristics();

		if ( $perf['phpCallsRequireSerialization'] ) {
			$lib = array(
				// Pattern matching is still much faster in PHP, even with the
				// overhead of serialization
				'find' => array( $this, 'ustringFind' ),
				'match' => array( $this, 'ustringMatch' ),
				'gmatch_init' => array( $this, 'ustringGmatchInit' ),
				'gmatch_callback' => array( $this, 'ustringGmatchCallback' ),
				'gsub' => array( $this, 'ustringGsub' ),
			);
		} else {
			$lib = array(
				'isutf8' => array( $this, 'ustringIsUtf8' ),
				'byteoffset' => array( $this, 'ustringByteoffset' ),
				'codepoint' => array( $this, 'ustringCodepoint' ),
				'toNFC' => array( $this, 'ustringToNFC' ),
				'toNFD' => array( $this, 'ustringToNFD' ),
				'char' => array( $this, 'ustringChar' ),
				'len' => array( $this, 'ustringLen' ),
				'sub' => array( $this, 'ustringSub' ),
				'upper' => array( $this, 'ustringUpper' ),
				'lower' => array( $this, 'ustringLower' ),
				'find' => array( $this, 'ustringFind' ),
				'match' => array( $this, 'ustringMatch' ),
				'gmatch_init' => array( $this, 'ustringGmatchInit' ),
				'gmatch_callback' => array( $this, 'ustringGmatchCallback' ),
				'gsub' => array( $this, 'ustringGsub' ),
			);
		}
		$this->getEngine()->registerInterface( 'mw.ustring.lua', $lib, array(
			'stringLengthLimit' => $this->stringLengthLimit,
			'patternLengthLimit' => $this->patternLengthLimit,
		) );
	}

	// Once we no longer support PHP < 5.4, calls to this method may be replaced with
	// mb_check_encoding( $s, 'UTF-8' )
	private function checkEncoding( $s ) {
		$ok = mb_check_encoding( $s, 'UTF-8' );
		if ( $ok && $this->manualCheckForU110000AndUp ) {
			$ok = !preg_match( '/\xf4[\x90-\xbf]|[\xf5-\xff]/', $s );
		}
		return $ok;
	}

	private function checkString( $name, $s, $checkEncoding = true ) {
		if ( $this->getLuaType( $s ) == 'number' ) {
			$s = (string)$s;
		}
		$this->checkType( $name, 1, $s, 'string' );
		if ( $checkEncoding && !$this->checkEncoding( $s ) ) {
			throw new Scribunto_LuaError( "bad argument #1 to '$name' (string is not UTF-8)" );
		}
		if ( strlen( $s ) > $this->stringLengthLimit ) {
			throw new Scribunto_LuaError(
				"bad argument #1 to '$name' (string is longer than $this->stringLengthLimit bytes)"
			);
		}
	}

	public function ustringIsUtf8( $s ) {
		$this->checkString( 'isutf8', $s, false );
		return array( $this->checkEncoding( $s ) );
	}

	public function ustringByteoffset( $s, $l = 1, $i = 1 ) {
		$this->checkString( 'byteoffset', $s );
		$this->checkTypeOptional( 'byteoffset', 2, $l, 'number', 1 );
		$this->checkTypeOptional( 'byteoffset', 3, $i, 'number', 1 );

		$bytelen = strlen( $s );
		if ( $i < 0 ) {
			$i = $bytelen + $i - 1;
		}
		if ( $i < 1 || $i > $bytelen ) {
			return array( null );
		}
		$i--;
		$j = $i;
		while ( ( ord( $s[$i] ) & 0xc0 ) === 0x80 ) {
			$i--;
		}
		if ( $l > 0 && $j === $i ) {
			$l--;
		}
		$char = mb_strlen( substr( $s, 0, $i ), 'UTF-8' ) + $l;
		if ( $char < 0 || $char >= mb_strlen( $s, 'UTF-8' ) ) {
			return array( null );
		} else {
			return array( strlen( mb_substr( $s, 0, $char, 'UTF-8' ) ) + 1 );
		}
	}

	public function ustringCodepoint( $s, $i = 1, $j = null ) {
		$this->checkString( 'codepoint', $s );
		$this->checkTypeOptional( 'codepoint', 2, $i, 'number', 1 );
		$this->checkTypeOptional( 'codepoint', 3, $j, 'number', $i );

		$l = mb_strlen( $s, 'UTF-8' );
		if ( $i < 0 ) {
			$i = $l + $i + 1;
		}
		if ( $j < 0 ) {
			$j = $l + $j + 1;
		}
		$i = max( 1, min( $i, $l ) );
		$j = max( 1, min( $j, $l ) );
		$s = mb_substr( $s, $i - 1, $j - $i + 1, 'UTF-8' );
		return unpack( 'N*', mb_convert_encoding( $s, 'UTF-32BE', 'UTF-8' ) );
	}

	public function ustringToNFC( $s ) {
		$this->checkString( 'toNFC', $s, false );
		if ( !$this->checkEncoding( $s ) ) {
			return array( null );
		}
		return array( UtfNormal::toNFC( $s ) );
	}

	public function ustringToNFD( $s ) {
		$this->checkString( 'toNFD', $s, false );
		if ( !$this->checkEncoding( $s ) ) {
			return array( null );
		}
		return array( UtfNormal::toNFD( $s ) );
	}

	public function ustringChar() {
		$args = func_get_args();
		if ( count( $args ) > $this->stringLengthLimit ) {
			throw new Scribunto_LuaError( "too many arguments to '$name'" );
		}
		foreach ( $args as $k=>&$v ) {
			if ( !is_numeric( $v ) ) {
				$this->checkType( 'char', $k+1, $v, 'number' );
			}
			$v = (int)floor( $v );
			if ( $v < 0 || $v > 0x10ffff ) {
				$k++;
				throw new Scribunto_LuaError( "bad argument #$k to 'char' (value out of range)" );
			}
		}
		array_unshift( $args, 'N*' );
		$s = call_user_func_array( 'pack', $args );
		$s = mb_convert_encoding( $s, 'UTF-8', 'UTF-32BE' );
		if ( strlen( $s ) > $this->stringLengthLimit ) {
			throw new Scribunto_LuaError( "result to long for '$name'" );
		}
		return array( $s );
	}

	public function ustringLen( $s ) {
		$this->checkString( 'len', $s, false );
		if ( !$this->checkEncoding( $s ) ) {
			return array( null );
		}
		return array( mb_strlen( $s, 'UTF-8' ) );
	}

	public function ustringSub( $s, $i=1, $j=-1 ) {
		$this->checkString( 'sub', $s );
		$this->checkTypeOptional( 'sub', 2, $i, 'number', 1 );
		$this->checkTypeOptional( 'sub', 3, $j, 'number', -1 );

		$len = mb_strlen( $s, 'UTF-8' );
		if ( $i < 0 ) {
			$i = $len + $i + 1;
		}
		if ( $j < 0 ) {
			$j = $len + $j + 1;
		}
		$i = max( 1, min( $i, $len + 1 ) );
		$j = max( 1, min( $j, $len + 1 ) );
		$s = mb_substr( $s, $i - 1, $j - $i + 1, 'UTF-8' );
		return array( $s );
	}

	public function ustringUpper( $s ) {
		$this->checkString( 'upper', $s );
		return array( mb_strtoupper( $s, 'UTF-8' ) );
	}

	public function ustringLower( $s ) {
		$this->checkString( 'lower', $s );
		return array( mb_strtolower( $s, 'UTF-8' ) );
	}

	private function checkPattern( $name, $pattern ) {
		if ( $this->getLuaType( $pattern ) == 'number' ) {
			$pattern = (string)$pattern;
		}
		$this->checkType( $name, 2, $pattern, 'string' );
		if ( !$this->checkEncoding( $pattern ) ) {
			throw new Scribunto_LuaError( "bad argument #2 to '$name' (string is not UTF-8)" );
		}
		if ( strlen( $pattern ) > $this->patternLengthLimit ) {
			throw new Scribunto_LuaError(
				"bad argument #2 to '$name' (pattern is longer than $this->patternLengthLimit bytes)"
			);
		}
	}

	/* Convert a Lua pattern into a PCRE regex */
	private function patternToRegex( $pattern, $noAnchor = false ) {
		$pat = preg_split( '//us', $pattern, null, PREG_SPLIT_NO_EMPTY );

		static $charsets = null, $brcharsets = null;
		if ( $charsets === null ) {
			$charsets = array(
				// If you change these, also change lualib/ustring/make-tables.php
				// (and run it to regenerate charsets.lua)
				'a' => '\p{L}',
				'c' => '\p{Cc}',
				'd' => '\p{Nd}',
				'l' => '\p{Ll}',
				'p' => '\p{P}',
				's' => '\p{Xps}',
				'u' => '\p{Lu}',
				'w' => '[\p{L}\p{Nd}]',
				'x' => '[0-9A-Fa-f０-９Ａ-Ｆａ-ｆ]',
				'z' => '\0',

				// These *must* be the inverse of the above
				'A' => '\P{L}',
				'C' => '\P{Cc}',
				'D' => '\P{Nd}',
				'L' => '\P{Ll}',
				'P' => '\P{P}',
				'S' => '\P{Xps}',
				'U' => '\P{Lu}',
				'W' => '[\P{L}\P{Nd}]',
				'X' => '[^0-9A-Fa-f０-９Ａ-Ｆａ-ｆ]',
				'Z' => '[^\0]',
			);
			$brcharsets = array(
				'w' => '\p{L}\p{Nd}',
				'x' => '0-9A-Fa-f０-９Ａ-Ｆａ-ｆ',

				// Negated sets that are not expressable as a simple \P{} are
				// unfortunately complicated.

				// Xan is L plus N, so ^Xan plus Nl plus No is anything that's not L or Nd
				'W' => '\P{Xan}\p{Nl}\p{No}',

				// Manually constructed. Fun.
				'X' => '\x00-\x2f\x3a-\x40\x47-\x60\x67-\x{ff0f}'
					. '\x{ff1a}-\x{ff20}\x{ff27}-\x{ff40}\x{ff47}-\x{10ffff}',

				// Ha!
				'Z' => '\x01-\x{10ffff}',
			) + $charsets;
		}

		$re = '/';
		$len = count( $pat );
		$capt = array();
		$anypos = false;
		$captparen = array();
		$opencapt = array();
		$bct = 0;
		for ( $i = 0; $i < $len; $i++ ) {
			$ii = $i + 1;
			$q = false;
			switch ( $pat[$i] ) {
			case '^':
				$q = $i;
				$re .= ( $noAnchor || $q ) ? '\\^' : '^';
				break;

			case '$':
				$q = ( $i < $len - 1 );
				$re .= $q ? '\\$' : '$';
				break;

			case '(':
				if ( $i + 1 >= $len ) {
					throw new Scribunto_LuaError( "Unmatched open-paren at pattern character $ii" );
				}
				$n = count( $capt ) + 1;
				$capt[$n] = ( $pat[$i + 1] === ')' );
				if ( $capt[$n] ) {
					$anypos = true;
				}
				$re .= "(?<m$n>";
				$opencapt[] = $n;
				$captparen[$n] = $ii;
				break;

			case ')':
				if ( count( $opencapt ) <= 0 ) {
					throw new Scribunto_LuaError( "Unmatched close-paren at pattern character $ii" );
				}
				array_pop( $opencapt );
				$re .= $pat[$i];
				break;

			case '%':
				$i++;
				if ( $i >= $len ) {
					throw new Scribunto_LuaError( "malformed pattern (ends with '%')" );
				}
				if ( isset( $charsets[$pat[$i]] ) ) {
					$re .= $charsets[$pat[$i]];
					$q = true;
				} elseif ( $pat[$i] === 'b' ) {
					if ( $i + 2 >= $len ) {
						throw new Scribunto_LuaError( "malformed pattern (missing arguments to \'%b\')" );
					}
					$d1 = preg_quote( $pat[++$i], '/' );
					$d2 = preg_quote( $pat[++$i], '/' );
					if ( $d1 === $d2 ) {
						$re .= "{$d1}[^$d1]*$d1";
					} else {
						$bct++;
						$re .= "(?<b$bct>$d1(?:(?>[^$d1$d2]+)|(?P>b$bct))*$d2)";
					}
				} elseif ( $pat[$i] >= '0' && $pat[$i] <= '9' ) {
					$n = ord( $pat[$i] ) - 0x30;
					if ( $n === 0 || $n > count( $capt ) || in_array( $n, $opencapt ) ) {
						throw new Scribunto_LuaError( "invalid capture index %$n at pattern character $ii" );
					}
					$re .= "\\g{m$n}";
				} else {
					$re .= preg_quote( $pat[$i], '/' );
					$q = true;
				}
				break;

			case '[':
				$re .= '[';
				$i++;
				if ( $i < $len && $pat[$i] === '^' ) {
					$re .= '^';
					$i++;
				}
				for ( ; $i < $len && $pat[$i] !== ']'; $i++ ) {
					if ( $pat[$i] === '%' ) {
						$i++;
						if ( $i >= $len ) {
							break;
						}
						if ( isset( $brcharsets[$pat[$i]] ) ) {
							$re .= $brcharsets[$pat[$i]];
						} else {
							$re .= preg_quote( $pat[$i], '/' );
						}
					} elseif( $i + 2 < $len && $pat[$i + 1] === '-' && $pat[$i + 2] !== ']' ) {
						$re .= preg_quote( $pat[$i], '/' ) . '-' . preg_quote( $pat[$i+2], '/' );
						$i += 2;
					} else {
						$re .= preg_quote( $pat[$i], '/' );
					}
				}
				if ( $i >= $len ) {
					throw new Scribunto_LuaError( "Missing close-bracket for character set beginning at pattern character $ii" );
				}
				$re .= ']';
				$q = true;
				break;

			case ']':
				throw new Scribunto_LuaError( "Unmatched close-bracket at pattern character $ii" );

			case '.':
				$re .= $pat[$i];
				$q = true;
				break;

			default:
				$re .= preg_quote( $pat[$i], '/' );
				$q = true;
				break;
			}
			if ( $q && $i + 1 < $len ) {
				switch ( $pat[$i + 1] ) {
				case '*':
				case '+':
				case '?':
					$re .= $pat[++$i];
					break;
				case '-':
					$re .= '*?';
					$i++;
					break;
				}
			}
		}
		if ( count( $opencapt ) ) {
			$ii = $captparen[$opencapt[0]];
			throw new Scribunto_LuaError( "Unclosed capture beginning at pattern character $ii" );
		}
		$re .= '/us';
		return array( $re, $capt, $anypos );
	}

	private function addCapturesFromMatch( $arr, $s, $m, $capt, $offset, $m0_if_no_captures ) {
		if ( count( $capt ) ) {
			foreach ( $capt as $n => $pos ) {
				if ( $pos ) {
					$o = mb_strlen( substr( $s, 0, $m["m$n"][1] ), 'UTF-8' ) + $offset;
					$arr[] = $o;
				} else {
					$arr[] = $m["m$n"][0];
				}
			}
		} elseif ( $m0_if_no_captures ) {
			$arr[] = $m[0][0];
		}
		return $arr;
	}

	public function ustringFind( $s, $pattern, $init = 1, $plain = false ) {
		$this->checkString( 'find', $s );
		$this->checkPattern( 'find', $pattern );
		$this->checkTypeOptional( 'find', 3, $init, 'number', 1 );
		$this->checkTypeOptional( 'find', 4, $plain, 'boolean', false );

		$len = mb_strlen( $s, 'UTF-8' );
		if ( $init < 0 ) {
			$init = $len + $init + 1;
		}

		if ( $init > 1 ) {
			$s = mb_substr( $s, $init - 1, $len - $init + 1, 'UTF-8' );
		} else {
			$init = 1;
		}

		if ( $plain ) {
			$ret = mb_strpos( $s, $pattern, 0, 'UTF-8' );
			if ( $ret === false ) {
				return array( null );
			} else {
				return array( $ret + $init, $ret + $init + mb_strlen( $pattern ) - 1 );
			}
		}

		list( $re, $capt ) = $this->patternToRegex( $pattern );
		if ( !preg_match( $re, $s, $m, PREG_OFFSET_CAPTURE ) ) {
			return array( null );
		}
		$o = mb_strlen( substr( $s, 0, $m[0][1] ), 'UTF-8' ) + $init;
		$ret = array( $o, $o + mb_strlen( $m[0][0], 'UTF-8' ) - 1 );
		return $this->addCapturesFromMatch( $ret, $s, $m, $capt, $init, false );
	}

	public function ustringMatch( $s, $pattern, $init = 1 ) {
		$this->checkString( 'match', $s );
		$this->checkPattern( 'match', $pattern );
		$this->checkTypeOptional( 'match', 3, $init, 'number', 1 );

		$len = mb_strlen( $s, 'UTF-8' );
		if ( $init < 0 ) {
			$init = $len + $init + 1;
		}
		if ( $init > 1 ) {
			$s = mb_substr( $s, $init - 1, $len - $init + 1, 'UTF-8' );
		} else {
			$init = 1;
		}

		list( $re, $capt ) = $this->patternToRegex( $pattern );
		if ( !preg_match( $re, $s, $m, PREG_OFFSET_CAPTURE ) ) {
			return array( null );
		}
		return $this->addCapturesFromMatch( array(), $s, $m, $capt, $init, true );
	}

	public function ustringGmatchInit( $s, $pattern ) {
		$this->checkString( 'gmatch', $s );
		$this->checkPattern( 'gmatch', $pattern );

		list( $re, $capt ) = $this->patternToRegex( $pattern, true );
		return array( $re, $capt );
	}

	public function ustringGmatchCallback( $s, $re, $capt, $pos ) {
		if ( !preg_match( $re, $s, $m, PREG_OFFSET_CAPTURE, $pos ) ) {
			return array( $pos, array() );
		}
		$pos = $m[0][1] + strlen( $m[0][0] );
		return array( $pos, $this->addCapturesFromMatch( array( null ), $s, $m, $capt, 1, true ) );
	}

	public function ustringGsub( $s, $pattern, $repl, $n = null ) {
		$this->checkString( 'gsub', $s );
		$this->checkPattern( 'gsub', $pattern );
		$this->checkTypeOptional( 'gsub', 4, $n, 'number', null );

		if ( $n === null ) {
			$n = -1;
		} elseif ( $n < 0 ) {
			$n = 0;
		}

		list( $re, $capt, $anypos ) = $this->patternToRegex( $pattern );
		$captures = array();

		if ( $anypos ) {
			// preg_replace_callback doesn't take a "flags" argument, so we
			// can't pass PREG_OFFSET_CAPTURE to it, which is needed to handle
			// position captures. So instead we have to do a preg_match_all and
			// handle the captures ourself.
			$ct = preg_match_all( $re, $s, $mm, PREG_OFFSET_CAPTURE | PREG_SET_ORDER );
			if ( $n >= 0 ) {
				$ct = min( $ct, $n );
			}
			for ( $i = 0; $i < $ct; $i++ ) {
				$m = $mm[$i];
				$c = array( $m[0][0] );
				foreach ( $this->addCapturesFromMatch( array(), $s, $m, $capt, 1, false ) as $k => $v ) {
					$k++;
					$c["m$k"] = $v;
				}
				$captures[] = $c;
			}
		}

		switch ( $this->getLuaType( $repl ) ) {
		case 'string':
		case 'number':
			$cb = function ( $m ) use ( $repl, $anypos, &$captures ) {
				if ( $anypos ) {
					$m = array_shift( $captures );
				}
				return preg_replace_callback( '/%([%0-9])/', function ( $m2 ) use ( $m ) {
					$x = $m2[1];
					if ( $x === '%' ) {
						return '%';
					} elseif ( $x === '0' ) {
						return $m[0];
					} elseif ( isset( $m["m$x"] ) ) {
						return $m["m$x"];
					} else {
						throw new Scribunto_LuaError( "invalid capture index %$x in replacement string" );
					}
				}, $repl );
			};
			break;

		case 'table':
			$cb = function ( $m ) use ( $repl, $anypos, &$captures ) {
				if ( $anypos ) {
					$m = array_shift( $captures );
				}
				$x = isset( $m['m1'] ) ? $m['m1'] : $m[0];
				return isset( $repl[$x] ) ? $repl[$x] : $m[0];
			};
			break;

		case 'function':
			$interpreter = $this->getInterpreter();
			$cb = function ( $m ) use ( $interpreter, $capt, $repl, $anypos, &$captures ) {
				if ( $anypos ) {
					$m = array_shift( $captures );
				}
				$args = array( $repl );
				if ( count( $capt ) ) {
					foreach ( $capt as $i => $pos ) {
						$args[] = $m["m$i"];
					}
				} else {
					$args[] = $m[0];
				}
				$ret = call_user_func_array( array( $interpreter, 'callFunction' ), $args );
				if ( count( $ret ) === 0 || $ret[0] === null ) {
					return $m[0];
				}
				return $ret[0];
			};
			break;

		default:
			$this->checkType( 'gsub', 3, $repl, 'function or table or string' );
		}

		$count = 0;
		$s2 = preg_replace_callback( $re, $cb, $s, $n, $count );
		return array( $s2, $count );
	}
}
