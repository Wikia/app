<?php
if ( !defined( 'MEDIAWIKI' ) ) {
	die();
}
/**
Abuse filter parser.
Copyright © Victor Vasiliev, 2008. Based on ideas by Andrew Garrett Distributed under GNU GPL v2 terms.

Types of token:
* T_NONE - special-purpose token
* T_BRACE  - ( or )
* T_COMMA - ,
* T_OP - operator like + or ^
* T_NUMBER - number
* T_STRING - string, in "" or ''
* T_KEYWORD - keyword
* T_ID - identifier
* T_STATEMENT_SEPARATOR - ;
* T_SQUARE_BRACKETS - [ or ]

Levels of parsing:
* Entry - catches unexpected characters
* Semicolon - ;
* Set - :=
* Conditionls (IF) - if-then-else-end, cond ? a :b
* BoolOps (BO) - &, |, ^
* CompOps (CO) - ==, !=, ===, !==, >, <, >=, <=
* SumRel (SR) - +, -
* MulRel (MR) - *, /, %
* Pow (P) - **
* BoolNeg (BN) - ! operation
* SpecialOperators (SO) - in and like
* Unarys (U) - plus and minus in cases like -5 or -(2 * +2)
* ListElement (LE) - list[number]
* Braces (B) - ( and )
* Functions (F)
* Atom (A) - return value
*/

class AFPToken {
	// Types of tken
	const TNone = 'T_NONE';
	const TID = 'T_ID';
	const TKeyword = 'T_KEYWORD';
	const TString = 'T_STRING';
	const TInt = 'T_INT';
	const TFloat = 'T_FLOAT';
	const TOp = 'T_OP';
	const TBrace = 'T_BRACE';
	const TSquareBracket = 'T_SQUARE_BRACKET';
	const TComma = 'T_COMMA';
	const TStatementSeparator = 'T_STATEMENT_SEPARATOR';

	var $type;
	var $value;
	var $pos;

	public function __construct( $type = self::TNone, $value = null, $pos = 0 ) {
		$this->type = $type;
		$this->value = $value;
		$this->pos = $pos;
	}
}

class AFPData {
	// Datatypes
	const DInt = 'int';
	const DString = 'string';
	const DNull   = 'null';
	const DBool   = 'bool';
	const DFloat  = 'float';
	const DList   = 'list';

	var $type;
	var $data;

	public function __construct( $type = self::DNull, $val = null ) {
		$this->type = $type;
		$this->data = $val;
	}

	public static function newFromPHPVar( $var ) {
		if ( is_string( $var ) ) {
			return new AFPData( self::DString, $var );
		} elseif ( is_int( $var ) ) {
			return new AFPData( self::DInt, $var );
		} elseif ( is_float( $var ) ) {
			return new AFPData( self::DFloat, $var );
		} elseif ( is_bool( $var ) ) {
			return new AFPData( self::DBool, $var );
		} elseif ( is_array( $var ) ) {
			$result = array();
			foreach ( $var as $item ) {
				$result[] = self::newFromPHPVar( $item );
			}
			return new AFPData( self::DList, $result );
		} elseif ( is_null( $var ) ) {
			return new AFPData();
		} else {
			throw new AFPException(
				'Data type ' . gettype( $var ) . ' is not supported by AbuseFilter'
			);
		}
	}

	public function dup() {
		return new AFPData( $this->type, $this->data );
	}

	public static function castTypes( $orig, $target ) {
		if ( $orig->type == $target ) {
			return $orig->dup();
		}
		if ( $target == self::DNull ) {
			return new AFPData();
		}

		if ( $orig->type == self::DList ) {
			if ( $target == self::DBool ) {
				return new AFPData( self::DBool, (bool)count( $orig->data ) );
			}
			if ( $target == self::DFloat ) {
				return new AFPData( self::DFloat, doubleval( count( $orig->data  ) ) );
			}
			if ( $target == self::DInt ) {
				return new AFPData( self::DInt, intval( count( $orig->data ) ) );
			}
			if ( $target == self::DString ) {
				$s = '';
				foreach ( $orig->data as $item ) {
					$s .= $item->toString() . "\n";
				}
				return new AFPData( self::DString, $s );
			}
		}

		if ( $target == self::DBool ) {
			return new AFPData( self::DBool, (bool)$orig->data );
		}
		if ( $target == self::DFloat ) {
			return new AFPData( self::DFloat, doubleval( $orig->data ) );
		}
		if ( $target == self::DInt ) {
			return new AFPData( self::DInt, intval( $orig->data ) );
		}
		if ( $target == self::DString ) {
			return new AFPData( self::DString, strval( $orig->data ) );
		}
		if ( $target == self::DList ) {
			return new AFPData( self::DList, array( $orig ) );
		}
	}

	public static function boolInvert( $value ) {
		return new AFPData( self::DBool, !$value->toBool() );
	}

	public static function pow( $base, $exponent ) {
		return new AFPData( self::DFloat, pow( $base->toFloat(), $exponent->toFloat() ) );
	}

	public static function keywordIn( $a, $b ) {
		$a = $a->toString();
		$b = $b->toString();

		if ( $a == '' || $b == '' ) {
			return new AFPData( self::DBool, false );
		}

		return new AFPData( self::DBool, in_string( $a, $b ) );
	}

	public static function keywordContains( $a, $b ) {
		$a = $a->toString();
		$b = $b->toString();

		if ( $a == '' || $b == '' ) {
			return new AFPData( self::DBool, false );
		}

		return new AFPData( self::DBool, in_string( $b, $a ) );
	}

	public static function listContains( $value, $list ) {
		// Should use built-in PHP function somehow
		foreach ( $list->data as $item ) {
			if ( self::equals( $value, $item ) ) {
				return true;
			}
		}
		return false;
	}

	public static function equals( $d1, $d2 ) {
		return $d1->type != self::DList && $d2->type != self::DList &&
			$d1->toString() === $d2->toString();
	}

	public static function keywordLike( $str, $pattern ) {
		$str = $str->toString();
		$pattern = $pattern->toString();
		wfSuppressWarnings();
		$result = fnmatch( $pattern, $str );
		wfRestoreWarnings();
		return new AFPData( self::DBool, (bool)$result );
	}

	public static function keywordRegex( $str, $regex, $pos, $insensitive = false ) {
		$str = $str->toString();
		$pattern = $regex->toString();

		$pattern = preg_replace( '!(\\\\\\\\)*(\\\\)?/!', '$1\/', $pattern );
		$pattern = "/$pattern/u";

		if( $insensitive ) {
			$pattern .= 'i';
		}

		$handler = new AFPRegexErrorHandler( $pattern, $pos );
		try {
			$handler->install();
			$result = preg_match( $pattern, $str );
			$handler->restore();
		} catch ( Exception $e ) {
			$handler->restore();
			throw $e;
		}
		return new AFPData( self::DBool, (bool)$result );
	}

	public static function keywordRegexInsensitive( $str, $regex, $pos ) {
		return self::keywordRegex( $str, $regex, $pos, true );
	}

	public static function unaryMinus( $data ) {
		if ( $data->type == self::DInt ) {
			return new AFPData( $data->type, - $data->toInt() );
		} else {
			return new AFPData( $data->type, - $data->toFloat() );
		}
	}

	public static function boolOp( $a, $b, $op ) {
		$a = $a->toBool();
		$b = $b->toBool();
		if ( $op == '|' ) {
			return new AFPData( self::DBool, $a || $b );
		}
		if ( $op == '&' ) {
			return new AFPData( self::DBool, $a && $b );
		}
		if ( $op == '^' ) {
			return new AFPData( self::DBool, $a xor $b );
		}
		throw new AFPException( "Invalid boolean operation: {$op}" ); // Should never happen.
	}

	public static function compareOp( $a, $b, $op ) {
		if ( $op == '==' || $op == '=' ) {
			return new AFPData( self::DBool, self::equals( $a, $b ) );
		}
		if ( $op == '!=' ) {
			return new AFPData( self::DBool, !self::equals( $a, $b ) );
		}
		if ( $op == '===' ) {
			return new AFPData( self::DBool, $a->type == $b->type && self::equals( $a, $b ) );
		}
		if ( $op == '!==' ) {
			return new AFPData( self::DBool, $a->type != $b->type || !self::equals( $a, $b ) );
		}
		$a = $a->toString();
		$b = $b->toString();
		if ( $op == '>' ) {
			return new AFPData( self::DBool, $a > $b );
		}
		if ( $op == '<' ) {
			return new AFPData( self::DBool, $a < $b );
		}
		if ( $op == '>=' ) {
			return new AFPData( self::DBool, $a >= $b );
		}
		if ( $op == '<=' ) {
			return new AFPData( self::DBool, $a <= $b );
		}
		throw new AFPException( "Invalid comparison operation: {$op}" ); // Should never happen
	}

	public static function mulRel( $a, $b, $op, $pos ) {
		// Figure out the type.
		if ( $a->type == self::DFloat || $b->type == self::DFloat ||
			$a->toFloat() != $a->toString() || $b->toFloat() != $b->toString() ) {
			$type = self::DFloat;
			$a = $a->toFloat();
			$b = $b->toFloat();
		} else {
			$type = self::DInt;
			$a = $a->toInt();
			$b = $b->toInt();
		}

		if ( $op != '*' && $b == 0 ) {
			throw new AFPUserVisibleException( 'dividebyzero', $pos, array( $a ) );
		}

		if ( $op == '*' ) {
			$data = $a * $b;
		} elseif ( $op == '/' ) {
			$data = $a / $b;
		} elseif ( $op == '%' ) {
			$data = $a % $b;
		} else {
			throw new AFPException( "Invalid multiplication-related operation: {$op}" ); // Should never happen
		}

		if ( $type == self::DInt ) {
			$data = intval( $data );
		} else {
			$data = doubleval( $data );
		}

		return new AFPData( $type, $data );
	}

	public static function sum( $a, $b ) {
		if ( $a->type == self::DString || $b->type == self::DString ) {
			return new AFPData( self::DString, $a->toString() . $b->toString() );
		} elseif ( $a->type == self::DList && $b->type == self::DList ) {
			return new AFPData( self::DList, array_merge( $a->toList(), $b->toList() ) );
		} else {
			return new AFPData( self::DFloat, $a->toFloat() + $b->toFloat() );
		}
	}

	public static function sub( $a, $b ) {
		return new AFPData( self::DFloat, $a->toFloat() - $b->toFloat() );
	}

	/** Convert shorteners */

	/**
	 * @return bool
	 */
	public function toBool() {
		return self::castTypes( $this, self::DBool )->data;
	}

	/**
	 * @return string
	 */
	public function toString() {
		return self::castTypes( $this, self::DString )->data;
	}

	/**
	 * @return float
	 */
	public function toFloat() {
		return self::castTypes( $this, self::DFloat )->data;
	}

	/**
	 * @return int
	 */
	public function toInt() {
		return self::castTypes( $this, self::DInt )->data;
	}

	public function toList() {
		return self::castTypes( $this, self::DList )->data;
	}
}

class AFPParserState {
	var $pos, $token, $lastInput;

	public function __construct( $token, $pos ) {
		$this->token = $token;
		$this->pos = $pos;
		$this->lastInput = AbuseFilterParser::$lastHandledToken;
	}
}

class AFPException extends MWException { }

// Exceptions that we might conceivably want to report to ordinary users
// (i.e. exceptions that don't represent bugs in the extension itself)
class AFPUserVisibleException extends AFPException {
	function __construct( $exception_id, $position, $params ) {
		$msg = wfMsgExt( 'abusefilter-exception-' . $exception_id, array(), array_merge( array( $position ), $params ) );
		parent::__construct( $msg );

		$this->mExceptionID = $exception_id;
		$this->mPosition = $position;
		$this->mParams = $params;
	}
}

class AFPRegexErrorHandler {
	function __construct( $regex, $pos ) {
		$this->regex = $regex;
		$this->pos = $pos;
	}

	function handleError( $errno, $errstr, $errfile, $errline, $context ) {
		if ( error_reporting() == 0 ) {
			return true;
		}
		throw new AFPUserVisibleException(
			'regexfailure',
			$this->pos,
			array( $errstr, $this->regex )
		);
	}

	function install() {
		// no-op
	}

	function restore() {
		// no-op
	}
}

class AbuseFilterParser {
	var $mParams, $mVars, $mCode, $mTokens, $mPos, $mCur, $mShortCircuit, $mAllowShort;

	// length,lcase,ccnorm,rmdoubles,specialratio,rmspecials,norm,count
	static $mFunctions = array(
		'lcase' => 'funcLc',
		'length' => 'funcLen',
		'string' => 'castString',
		'int' => 'castInt',
		'float' => 'castFloat',
		'bool' => 'castBool',
		'norm' => 'funcNorm',
		'ccnorm' => 'funcCCNorm',
		'specialratio' => 'funcSpecialRatio',
		'rmspecials' => 'funcRMSpecials',
		'rmdoubles' => 'funcRMDoubles',
		'rmwhitespace' => 'funcRMWhitespace',
		'count' => 'funcCount',
		'rcount' => 'funcRCount',
		'ip_in_range' => 'funcIPInRange',
		'contains_any' => 'funcContainsAny',
		'substr' => 'funcSubstr',
		'strlen' => 'funcLen',
		'strpos' => 'funcStrPos',
		'str_replace' => 'funcStrReplace',
		'rescape' => 'funcStrRegexEscape',
		'set' => 'funcSetVar',
		'set_var' => 'funcSetVar',
	);

	// Functions that affect parser state, and shouldn't be cached.
	static $ActiveFunctions = array(
		'funcSetVar',
	);

	// Order is important. The punctuation-matching regex requires that
	//  ** comes before *, etc. They are sorted to make it easy to spot
	//  such errors.
	static $mOps = array(
		'!==', '!=', '!', 	// Inequality
		'**', '*', 			// Multiplication/exponentiation
		'/', '+', '-', '%', // Other arithmetic
		'&', '|', '^', 		// Logic
		':=',				// Setting
		'?', ':', 			// Ternery
		'<=', '<', 			// Less than
		'>=', '>', 			// Greater than
		'===', '==', '=', 	// Equality
	);

	static $mKeywords = array(
		'in', 'like', 'true', 'false', 'null', 'contains', 'matches',
		'rlike', 'irlike', 'regex', 'if', 'then', 'else', 'end',
	);

	static $parserCache = array();

	static $funcCache = array();

	static $lastHandledToken = array();

	public function __construct() {
		$this->resetState();
	}

	public function resetState() {
		$this->mParams = array();
		$this->mCode = '';
		$this->mTokens = array();
		$this->mVars = new AbuseFilterVariableHolder;
		$this->mPos = 0;
		$this->mShortCircuit = false;
		$this->mAllowShort = true;
	}

	public function checkSyntax( $filter ) {
		try {
			$origAS = $this->mAllowShort;
			$this->mAllowShort = false;
			$this->parse( $filter );
		} catch ( AFPUserVisibleException $excep ) {
			$this->mAllowShort = $origAS;
			return array( $excep->getMessage(), $excep->mPosition );
		}
		$this->mAllowShort = $origAS;
		return true;
	}

	public function setVar( $name, $value ) {
		$name = strtolower( $name );
		$this->mVars->setVar( $name, $value );
	}

	public function setVars( $vars ) {
		if ( is_array( $vars ) ) {
			foreach ( $vars as $name => $var ) {
				$this->setVar( $name, $var );
			}
		} elseif ( $vars instanceof AbuseFilterVariableHolder ) {
			$this->mVars->addHolder( $vars );
		}
	}

	protected function move( ) {
		wfProfileIn( __METHOD__ );
		list( $val, $type, $code, $offset ) =
			self::nextToken( $this->mCode, $this->mPos );

		$token = new AFPToken( $type, $val, $this->mPos );
		$this->mPos = $offset;
		wfProfileOut( __METHOD__ );
		return $this->mCur = $token;
	}

	// getState() and setState() function allows parser state to be rollbacked to several tokens back
	protected function getState() {
		return new AFPParserState( $this->mCur, $this->mPos );
	}

	protected function setState( AFPParserState $state ) {
		$this->mCur = $state->token;
		$this->mPos = $state->pos;
		self::$lastHandledToken = $state->lastInput;
	}

	protected function skipOverBraces() {
		if ( !( $this->mCur->type == AFPToken::TBrace && $this->mCur->value == '(' ) || !$this->mShortCircuit ) {
			return;
		}

		$braces = 1;
		wfProfileIn( __METHOD__ );
		while ( $this->mCur->type != AFPToken::TNone && $braces > 0 ) {
			$this->move();
			if ( $this->mCur->type == AFPToken::TBrace ) {
				if ( $this->mCur->value == '(' ) {
					$braces++;
				} elseif ( $this->mCur->value == ')' ) {
					$braces--;
				}
			}
		}
		wfProfileOut( __METHOD__ );
		if ( !( $this->mCur->type == AFPToken::TBrace && $this->mCur->value == ')' ) )
			throw new AFPUserVisibleException( 'expectednotfound', $this->mCur->pos, array( ')' ) );
	}

	public function parse( $code ) {
		return $this->intEval( $code )->toBool();
	}

	public function evaluateExpression( $filter ) {
		return $this->intEval( $filter )->toString();
	}

	function intEval( $code ) {
		// Setup, resetting
		$this->mCode = $code;
		$this->mPos = 0;
		$this->mLen = strlen( $code );
		$this->mShortCircuit = false;

		$result = new AFPData();
		$this->doLevelEntry( $result );
		return $result;
	}

	static function lengthCompare( $a, $b ) {
		if ( strlen( $a ) == strlen( $b ) ) {
			return 0;
		}

		return ( strlen( $a ) < strlen( $b ) ) ? - 1 : 1;
	}

	/* Levels */

	/**
	 * Handles unexpected characters after the expression
	 *
	 * @param $result
	 */
	protected function doLevelEntry( &$result ) {
		$this->doLevelSemicolon( $result );

		if ( $this->mCur->type != AFPToken::TNone ) {
			throw new AFPUserVisibleException( 'unexpectedatend', $this->mCur->pos, array( $this->mCur->type ) );
		}
	}

	/**
	 * Handles multiple expressions
	 * @param $result
	 */
	protected function doLevelSemicolon( &$result ) {
		do {
			$this->move();
			if ( $this->mCur->type != AFPToken::TStatementSeparator ) {
				$this->doLevelSet( $result );
			}
		} while ( $this->mCur->type == AFPToken::TStatementSeparator );
	}

	/**
	 * Handles multiple expressions
	 *
	 * @param $result
	 */
	protected function doLevelSet( &$result ) {
		if ( $this->mCur->type == AFPToken::TID ) {
			$varname = $this->mCur->value;
			$prev = $this->getState();
			$this->move();

			if ( $this->mCur->type == AFPToken::TOp && $this->mCur->value == ':=' ) {
				$this->move();
				$this->doLevelSet( $result );
				$this->setUserVariable( $varname, $result );
				return;
			} elseif ( $this->mCur->type == AFPToken::TSquareBracket && $this->mCur->value == '[' ) {
				if ( !$this->mVars->varIsSet( $varname ) ) {
					throw new AFPUserVisibleException( 'unrecognisedvar',
						$this->mCur->pos,
						array( $varname )
					);
				}
				$list = $this->mVars->getVar( $varname );
				if ( $list->type != AFPData::DList ) {
					throw new AFPUserVisibleException( 'notlist', $this->mCur->pos, array() );
				}
				$list = $list->toList();
				$this->move();
				if ( $this->mCur->type == AFPToken::TSquareBracket && $this->mCur->value == ']' ) {
					$idx = 'new';
				} else {
					$this->setState( $prev );
					$this->move();
					$idx = new AFPData();
					$this->doLevelSemicolon( $idx );
					$idx = $idx->toInt();
					if ( !( $this->mCur->type == AFPToken::TSquareBracket && $this->mCur->value == ']' ) ) {
						throw new AFPUserVisibleException( 'expectednotfound', $this->mCur->pos,
							array( ']', $this->mCur->type, $this->mCur->value ) );
					}
					if ( count( $list ) <= $idx ) {
						throw new AFPUserVisibleException( 'outofbounds', $this->mCur->pos,
							array( $idx, count( $result->data ) ) );
					}
				}
				$this->move();
				if ( $this->mCur->type == AFPToken::TOp && $this->mCur->value == ':=' ) {
					$this->move();
					$this->doLevelSet( $result );
					if ( $idx === 'new' ) {
						$list[] = $result;
					} else {
						$list[$idx] = $result;
					}
					$this->setUserVariable( $varname, new AFPData( AFPData::DList, $list ) );
					return;
				} else {
					$this->setState( $prev );
				}
			} else {
				$this->setState( $prev );
			}
		}
		$this->doLevelConditions( $result );
	}

	protected function doLevelConditions( &$result ) {
		if ( $this->mCur->type == AFPToken::TKeyword && $this->mCur->value == 'if' ) {
			$this->move();
			$this->doLevelBoolOps( $result );

			if ( !( $this->mCur->type == AFPToken::TKeyword && $this->mCur->value == 'then' ) )
				throw new AFPUserVisibleException( 'expectednotfound',
					$this->mCur->pos,
					array(
						'then',
						$this->mCur->type,
						$this->mCur->value
					)
				);
			$this->move();

			$r1 = new AFPData();
			$r2 = new AFPData();

			$isTrue = $result->toBool();

			if ( $isTrue ) {
				$scOrig = $this->mShortCircuit;
				$this->mShortCircuit = $this->mAllowShort;
			}
			$this->doLevelConditions( $r1 );
			if ( $isTrue ) {
				$this->mShortCircuit = $scOrig;
			}

			if ( !( $this->mCur->type == AFPToken::TKeyword && $this->mCur->value == 'else' ) )
				throw new AFPUserVisibleException( 'expectednotfound',
					$this->mCur->pos,
					array(
						'else',
						$this->mCur->type,
						$this->mCur->value
					)
				);
			$this->move();

			if ( !$isTrue ) {
				$scOrig = $this->mShortCircuit;
				$this->mShortCircuit = $this->mAllowShort;
			}
			$this->doLevelConditions( $r2 );
			if ( !$isTrue ) {
				$this->mShortCircuit = $scOrig;
			}

			if ( !( $this->mCur->type == AFPToken::TKeyword && $this->mCur->value == 'end' ) )
				throw new AFPUserVisibleException( 'expectednotfound',
					$this->mCur->pos,
					array(
						'end',
						$this->mCur->type,
						$this->mCur->value
					)
				);
			$this->move();

			if ( $result->toBool() ) {
				$result = $r1;
			} else {
				$result = $r2;
			}

		} else {
			$this->doLevelBoolOps( $result );
			if ( $this->mCur->type == AFPToken::TOp && $this->mCur->value == '?' ) {
				$this->move();
				$r1 = new AFPData();
				$r2 = new AFPData();

				$isTrue = $result->toBool();

				if ( $isTrue ) {
					$scOrig = $this->mShortCircuit;
					$this->mShortCircuit = $this->mAllowShort;
				}
				$this->doLevelConditions( $r1 );
				if ( $isTrue ) {
					$this->mShortCircuit = $scOrig;
				}

				if ( !( $this->mCur->type == AFPToken::TOp && $this->mCur->value == ':' ) )
					throw new AFPUserVisibleException( 'expectednotfound',
						$this->mCur->pos,
						array(
							':',
							$this->mCur->type,
							$this->mCur->value
						)
					);
				$this->move();

				if ( !$isTrue ) {
					$scOrig = $this->mShortCircuit;
					$this->mShortCircuit = $this->mAllowShort;
				}
				$this->doLevelConditions( $r2 );
				if ( !$isTrue ) {
					$this->mShortCircuit = $scOrig;
				}

				if ( $isTrue ) {
					$result = $r1;
				} else {
					$result = $r2;
				}
			}
		}
	}

	protected function doLevelBoolOps( &$result ) {
		$this->doLevelCompares( $result );
		$ops = array( '&', '|', '^' );
		while ( $this->mCur->type == AFPToken::TOp && in_array( $this->mCur->value, $ops ) ) {
			$op = $this->mCur->value;
			$this->move();
			$r2 = new AFPData();

			if ( $op == '&' && !( $result->toBool() ) ) {
				wfProfileIn( __METHOD__ . '-shortcircuit' );
				$orig = $this->mShortCircuit;
				$this->mShortCircuit = $this->mAllowShort;
				$this->doLevelCompares( $r2 );
				$this->mShortCircuit = $orig;
				$result = new AFPData( AFPData::DBool, false );
				wfProfileOut( __METHOD__ . '-shortcircuit' );
				continue;
			}

			if ( $op == '|' && $result->toBool() ) {
				wfProfileIn( __METHOD__ . '-shortcircuit' );
				$orig = $this->mShortCircuit;
				$this->mShortCircuit = $this->mAllowShort;
				$this->doLevelCompares( $r2 );
				$this->mShortCircuit = $orig;
				$result = new AFPData( AFPData::DBool, true );
				wfProfileOut( __METHOD__ . '-shortcircuit' );
				continue;
			}

			$this->doLevelCompares( $r2 );

			wfProfileIn( __METHOD__ );
			$result = AFPData::boolOp( $result, $r2, $op );
			wfProfileOut( __METHOD__ );
		}
	}

	protected function doLevelCompares( &$result ) {
		AbuseFilter::triggerLimiter();
		$this->doLevelSumRels( $result );
		$ops = array( '==', '===', '!=', '!==', '<', '>', '<=', '>=', '=' );
		while ( $this->mCur->type == AFPToken::TOp && in_array( $this->mCur->value, $ops ) ) {
			$op = $this->mCur->value;
			$this->move();
			$r2 = new AFPData();
			$this->doLevelSumRels( $r2 );
			wfProfileIn( __METHOD__ );
			$result = AFPData::compareOp( $result, $r2, $op );
			wfProfileOut( __METHOD__ );
		}
	}

	protected function doLevelSumRels( &$result ) {
		$this->doLevelMulRels( $result );
		wfProfileIn( __METHOD__ );
		$ops = array( '+', '-' );
		while ( $this->mCur->type == AFPToken::TOp && in_array( $this->mCur->value, $ops ) ) {
			$op = $this->mCur->value;
			$this->move();
			$r2 = new AFPData();
			$this->doLevelMulRels( $r2 );
			if ( $op == '+' ) {
				$result = AFPData::sum( $result, $r2 );
			}
			if ( $op == '-' ) {
				$result = AFPData::sub( $result, $r2 );
			}
		}
		wfProfileOut( __METHOD__ );
	}

	protected function doLevelMulRels( &$result ) {
		$this->doLevelPow( $result );
		wfProfileIn( __METHOD__ );
		$ops = array( '*', '/', '%' );
		while ( $this->mCur->type == AFPToken::TOp && in_array( $this->mCur->value, $ops ) ) {
			$op = $this->mCur->value;
			$this->move();
			$r2 = new AFPData();
			$this->doLevelPow( $r2 );
			$result = AFPData::mulRel( $result, $r2, $op, $this->mCur->pos );
		}
		wfProfileOut( __METHOD__ );
	}

	protected function doLevelPow( &$result ) {
		$this->doLevelBoolInvert( $result );
		wfProfileIn( __METHOD__ );
		while ( $this->mCur->type == AFPToken::TOp && $this->mCur->value == '**' ) {
			$this->move();
			$expanent = new AFPData();
			$this->doLevelBoolInvert( $expanent );
			$result = AFPData::pow( $result, $expanent );
		}
		wfProfileOut( __METHOD__ );
	}

	protected function doLevelBoolInvert( &$result ) {
		if ( $this->mCur->type == AFPToken::TOp && $this->mCur->value == '!' ) {
			$this->move();
			$this->doLevelSpecialWords( $result );
			wfProfileIn( __METHOD__ );
			$result = AFPData::boolInvert( $result );
			wfProfileOut( __METHOD__ );
		} else {
			$this->doLevelSpecialWords( $result );
		}
	}

	protected function doLevelSpecialWords( &$result ) {
		$this->doLevelUnarys( $result );
		$keyword = strtolower( $this->mCur->value );
		$specwords = array(
			'in' => 'keywordIn',
			'like' => 'keywordLike',
			'matches' => 'keywordLike',
			'contains' => 'keywordContains',
			'rlike' => 'keywordRegex',
			'irlike' => 'keywordRegexInsensitive',
			'regex' => 'keywordRegex'
		);
		if ( $this->mCur->type == AFPToken::TKeyword && in_array( $keyword, array_keys( $specwords ) ) ) {
			$func = $specwords[$keyword];
			$this->move();
			$r2 = new AFPData();
			$this->doLevelUnarys( $r2 );

			if ( $this->mShortCircuit ) {
				return; // The result doesn't matter.
			}

			wfProfileIn( __METHOD__ );

			wfProfileIn( __METHOD__ . "-$func" );
			$result = AFPData::$func( $result, $r2, $this->mCur->pos );
			wfProfileOut( __METHOD__ . "-$func" );
			wfProfileOut( __METHOD__ );
		}
	}

	protected function doLevelUnarys( &$result ) {
		$op = $this->mCur->value;
		if ( $this->mCur->type == AFPToken::TOp && ( $op == "+" || $op == "-" ) ) {
			$this->move();
			$this->doLevelListElements( $result );
			wfProfileIn( __METHOD__ );
			if ( $op == '-' ) {
				$result = AFPData::unaryMinus( $result );
			}
			wfProfileOut( __METHOD__ );
		} else {
			$this->doLevelListElements( $result );
		}
	}

	protected function doLevelListElements( &$result ) {
		$this->doLevelBraces( $result );
		while ( $this->mCur->type == AFPToken::TSquareBracket && $this->mCur->value == '[' ) {
			$idx = new AFPData();
			$this->doLevelSemicolon( $idx );
			if ( !( $this->mCur->type == AFPToken::TSquareBracket && $this->mCur->value == ']' ) ) {
				throw new AFPUserVisibleException( 'expectednotfound', $this->mCur->pos,
							array( ']', $this->mCur->type, $this->mCur->value ) );
			}
			$idx = $idx->toInt();
			if ( $result->type == AFPData::DList ) {
				if ( count( $result->data ) <= $idx ) {
					throw new AFPUserVisibleException( 'outofbounds', $this->mCur->pos,
						array( $idx, count( $result->data ) ) );
				}
				$result = $result->data[$idx];
			} else {
				throw new AFPUserVisibleException( 'notlist', $this->mCur->pos, array() );
			}
			$this->move();
		}
	}

	protected function doLevelBraces( &$result ) {
		if ( $this->mCur->type == AFPToken::TBrace && $this->mCur->value == '(' ) {
			if ( $this->mShortCircuit ) {
				$this->skipOverBraces();
			} else {
				$this->doLevelSemicolon( $result );
			}
			if ( !( $this->mCur->type == AFPToken::TBrace && $this->mCur->value == ')' ) )
				throw new AFPUserVisibleException(
					'expectednotfound',
					$this->mCur->pos,
					array( ')', $this->mCur->type, $this->mCur->value )
				);
			$this->move();
		} else {
			$this->doLevelFunction( $result );
		}
	}

	protected function doLevelFunction( &$result ) {
		if ( $this->mCur->type == AFPToken::TID && isset( self::$mFunctions[$this->mCur->value] ) ) {
			wfProfileIn( __METHOD__ );
			$func = self::$mFunctions[$this->mCur->value];
			$this->move();
			if ( $this->mCur->type != AFPToken::TBrace || $this->mCur->value != '(' ) {
				throw new AFPUserVisibleException( 'expectednotfound',
					$this->mCur->pos,
					array(
						'(',
						$this->mCur->type,
						$this->mCur->value
					)
				);
			}

			if ( $this->mShortCircuit ) {
				$this->skipOverBraces();
				$this->move();
				wfProfileOut( __METHOD__ );
				return; // The result doesn't matter.
			}

			wfProfileIn( __METHOD__ . '-loadargs' );
			$args = array();
			do {
				$r = new AFPData();
				$this->doLevelSemicolon( $r );
				$args[] = $r;
			} while ( $this->mCur->type == AFPToken::TComma );

			if ( $this->mCur->type != AFPToken::TBrace || $this->mCur->value != ')' ) {
				throw new AFPUserVisibleException( 'expectednotfound',
					$this->mCur->pos,
					array(
						')',
						$this->mCur->type,
						$this->mCur->value
					)
				);
			}
			$this->move();

			wfProfileOut( __METHOD__ . '-loadargs' );

			wfProfileIn( __METHOD__ . "-$func" );

			$funcHash = md5( $func . serialize( $args ) );

			if ( isset( self::$funcCache[$funcHash] ) &&
					!in_array( $func, self::$ActiveFunctions ) ) {
				$result = self::$funcCache[$funcHash];
			} else {
				AbuseFilter::triggerLimiter();
				$result = self::$funcCache[$funcHash] = $this->$func( $args );
			}

			if ( count( self::$funcCache ) > 1000 ) {
				self::$funcCache = array();
			}

			wfProfileOut( __METHOD__ . "-$func" );
			wfProfileOut( __METHOD__ );
		} else {
			$this->doLevelAtom( $result );
		}
	}

	protected function doLevelAtom( &$result ) {
		wfProfileIn( __METHOD__ );
		$tok = $this->mCur->value;
		switch( $this->mCur->type ) {
			case AFPToken::TID:
				if ( $this->mShortCircuit ) {
					break;
				}
				$var = strtolower( $tok );
				$result = $this->getVarValue( $var );
				break;
			case AFPToken::TString:
				$result = new AFPData( AFPData::DString, $tok );
				break;
			case AFPToken::TFloat:
				$result = new AFPData( AFPData::DFloat, $tok );
				break;
			case AFPToken::TInt:
				$result = new AFPData( AFPData::DInt, $tok );
				break;
			case AFPToken::TKeyword:
				if ( $tok == "true" ) {
					$result = new AFPData( AFPData::DBool, true );
				} elseif ( $tok == "false" ) {
					$result = new AFPData( AFPData::DBool, false );
				} elseif ( $tok == "null" ) {
					$result = new AFPData();
				} else {
					throw new AFPUserVisibleException(
						'unrecognisedkeyword',
						$this->mCur->pos,
						array( $tok )
					);
				}
				break;
			case AFPToken::TNone:
				wfProfileOut( __METHOD__ );
				return; // Handled at entry level
			case AFPToken::TBrace:
				if ( $this->mCur->value == ')' ) {
					wfProfileOut( __METHOD__ );
					return; // Handled at the entry level
				}
			case AFPToken::TSquareBracket:
				if ( $this->mCur->value == '[' ) {
					$list = array();
					for ( ; ; ) {
						$this->move();
						if ( $this->mCur->type == AFPToken::TSquareBracket && $this->mCur->value == ']' ) {
							break;
						}
						$item = new AFPData();
						$this->doLevelSet( $item );
						$list[] = $item;
						if ( $this->mCur->type == AFPToken::TSquareBracket && $this->mCur->value == ']' ) {
							break;
						}
						if ( $this->mCur->type != AFPToken::TComma ) {
							throw new AFPUserVisibleException(
								'expectednotfound',
								$this->mCur->pos,
								array( ', or ]', $this->mCur->type, $this->mCur->value )
							);
						}
					}
					$result = new AFPData( AFPData::DList, $list );
					break;
				}
			default:
				wfProfileOut( __METHOD__ );
				throw new AFPUserVisibleException(
					'unexpectedtoken',
					$this->mCur->pos,
					array(
						$this->mCur->type,
						$this->mCur->value
					)
				);
		}
		$this->move();
		wfProfileOut( __METHOD__ );
	}

	/* End of levels */

	protected function getVarValue( $var ) {
		wfProfileIn( __METHOD__ );
		$var = strtolower( $var );
		$builderValues = AbuseFilter::getBuilderValues();
		if ( !( array_key_exists( $var, $builderValues['vars'] )
				|| $this->mVars->varIsSet( $var ) ) ) {
			// If the variable is invalid, throw an exception
			wfProfileOut( __METHOD__ );
			throw new AFPUserVisibleException(
				'unrecognisedvar',
				$this->mCur->pos,
				array( $var )
			);
		} else {
			$val = $this->mVars->getVar( $var );
			wfProfileOut( __METHOD__ );
			return $val;
		}
	}

	protected function setUserVariable( $name, $value ) {
		$builderValues = AbuseFilter::getBuilderValues();
		if ( array_key_exists( $name, $builderValues['vars'] ) ) {
			throw new AFPUserVisibleException( 'overridebuiltin', $this->mCur->pos, array( $name ) );
		}
		$this->mVars->setVar( $name, $value );
	}

	static function nextToken( $code, $offset ) {
		$tok = '';

		// Check for infinite loops
		if ( self::$lastHandledToken == array( $code, $offset ) ) {
			// Should never happen
			throw new AFPException( "Entered infinite loop. Offset $offset of $code" );
		}

		self::$lastHandledToken = array( $code, $offset );

		// Spaces
		$matches = array();
		if ( preg_match( '/\s+/uA', $code, $matches, 0, $offset ) ) {
			$offset += strlen( $matches[0] );
		}

		if ( $offset >= strlen( $code ) ) {
			return array( '', AFPToken::TNone, $code, $offset );
		}

		// Comments
		if ( substr( $code, $offset, 2 ) == '/*' ) {
			$end = strpos( $code, '*/', $offset );

			return self::nextToken( $code, $end + 2 );
		}

		// Commas
		if ( $code[$offset] == ',' ) {
			return array( ',', AFPToken::TComma, $code, $offset + 1 );
		}

		// Braces
		if ( $code[$offset] == '(' or $code[$offset] == ')' ) {
			return array( $code[$offset], AFPToken::TBrace, $code, $offset + 1 );
		}

		// Square brackets
		if ( $code[$offset] == '[' or $code[$offset] == ']' ) {
			return array( $code[$offset], AFPToken::TSquareBracket, $code, $offset + 1 );
		}

		// Semicolons
		if ( $code[$offset] == ';' ) {
			return array( ';', AFPToken::TStatementSeparator, $code, $offset + 1 );
		}

		// Strings
		if ( $code[$offset] == '"' || $code[$offset] == "'" ) {
			$type = $code[$offset];
			$offset++;
			$strLen = strlen( $code );
			while ( $offset < $strLen ) {

				if ( $code[$offset] == $type ) {
					$offset++;
					return array( $tok, AFPToken::TString, $code, $offset );
				}

				// Performance: Use a PHP function (implemented in C)
				// to scan ahead.
				$addLength = strcspn( $code, $type . "\\", $offset );
				if ( $addLength ) {
					$tok .= substr( $code, $offset, $addLength );
					$offset += $addLength;
				} elseif ( $code[$offset] == '\\' ) {
					switch( $code[$offset + 1] ) {
						case '\\':
							$tok .= '\\';
							break;
						case $type:
							$tok .= $type;
							break;
						case 'n';
							$tok .= "\n";
							break;
						case 'r':
							$tok .= "\r";
							break;
						case 't':
							$tok .= "\t";
							break;
						case 'x':
							$chr = substr( $code, $offset + 2, 2 );

							if ( preg_match( '/^[0-9A-Fa-f]{2}$/', $chr ) ) {
								$chr = base_convert( $chr, 16, 10 );
								$tok .= chr( $chr );
								$offset += 2; # \xXX -- 2 done later
							} else {
								$tok .= 'x';
							}
							break;
						default:
							$tok .= "\\" . $code[$offset + 1];
					}

					$offset += 2;

				} else {
					$tok .= $code[$offset];
					$offset++;
				}
			}
			throw new AFPUserVisibleException( 'unclosedstring', $offset, array() );
		}

		// Find operators

		static $operator_regex = null;
		// Match using a regex. Regexes are faster than PHP
		if ( !$operator_regex ) {
			$quoted_operators = array();

			foreach ( self::$mOps as $op ) {
				$quoted_operators[] = preg_quote( $op, '/' );
			}
			$operator_regex = '/(' . implode( '|', $quoted_operators ) . ')/A';
		}

		$matches = array();

		preg_match( $operator_regex, $code, $matches, 0, $offset );

		if ( count( $matches ) ) {
			$tok = $matches[0];
			$offset += strlen( $tok );
			return array( $tok, AFPToken::TOp, $code, $offset );
		}

		// Find bare numbers
		$bases = array(
			'b' => 2,
			'x' => 16,
			'o' => 8
		);
		$baseChars = array(
			2 => '[01]',
			16 => '[0-9A-Fa-f]',
			8 => '[0-8]',
			10 => '[0-9.]',
		);
		$baseClass = '[' . implode( '', array_keys( $bases ) ) . ']';
		$radixRegex = "/([0-9A-Fa-f]+(?:\.\d*)?|\.\d+)($baseClass)?/Au";
		$matches = array();

		if ( preg_match( $radixRegex, $code, $matches, 0, $offset ) ) {
			$input = $matches[1];
			$baseChar = @$matches[2];
			// Sometimes the base char gets mixed in with the rest of it because
			// the regex targets hex, too.
			// This mostly happens with binary
			if ( !$baseChar && !empty( $bases[ substr( $input, - 1 ) ] ) ) {
				$baseChar = substr( $input, - 1, 1 );
				$input = substr( $input, 0, - 1 );
			}

			if ( $baseChar ) {
				$base = $bases[$baseChar];
			} else {
				$base = 10;
			}

			// Check against the appropriate character class for input validation
			$baseRegex = "/^" . $baseChars[$base] . "+$/";

			if ( preg_match( $baseRegex, $input ) ) {
				if ( $base != 10 ) {
					$num = base_convert( $input, $base, 10 );
				} else {
					$num = $input;
				}

				$offset += strlen( $matches[0] );

				$float = in_string( '.', $input );

				return array(
					$float
						? doubleval( $num )
						: intval( $num ),
					$float
						? AFPToken::TFloat
						: AFPToken::TInt,
					$code,
					$offset
				);
			}
		}

		// The rest are considered IDs

		// Regex match > PHP
		$idSymbolRegex = '/[0-9A-Za-z_]+/A';
		$matches = array();

		if ( preg_match( $idSymbolRegex, $code, $matches, 0, $offset ) ) {
			$tok = $matches[0];

			$type = in_array( $tok, self::$mKeywords )
				? AFPToken::TKeyword
				: AFPToken::TID;

			return array( $tok, $type, $code, $offset + strlen( $tok ) );
		}

		throw new AFPUserVisibleException(
			'unrecognisedtoken', $offset, array( substr( $code, $offset ) ) );
	}

	// Built-in functions
	protected function funcLc( $args ) {
		global $wgContLang;
		if ( count( $args ) < 1 ) {
			throw new AFPUserVisibleException(
				'notenoughargs',
				$this->mCur->pos,
				array( 'lc', 2, count( $args ) )
			);
		}
		$s = $args[0]->toString();
		return new AFPData( AFPData::DString, $wgContLang->lc( $s ) );
	}

	protected function funcLen( $args ) {
		if ( count( $args ) < 1 ) {
			throw new AFPUserVisibleException(
				'notenoughargs',
				$this->mCur->pos,
				array( 'len', 2, count( $args ) )
			);
		}
		$s = $args[0]->toString();
		return new AFPData( AFPData::DInt, mb_strlen( $s, 'utf-8' ) );
	}

	protected function funcSimpleNorm( $args ) {
		if ( count( $args ) < 1 ) {
			throw new AFPUserVisibleException(
				'notenoughargs',
				$this->mCur->pos,
				array( 'simplenorm', 2, count( $args ) )
			);
		}
		$s = $args[0]->toString();

		$s = preg_replace( '/[\d\W]+/', '', $s );
		$s = strtolower( $s );
		return new AFPData( AFPData::DString, $s );
	}

	protected function funcSpecialRatio( $args ) {
		if ( count( $args ) < 1 ) {
			throw new AFPUserVisibleException(
				'notenoughargs',
				$this->mCur->pos,
				array( 'specialratio', 1, count( $args ) )
			);
		}
		$s = $args[0]->toString();

		if ( !strlen( $s ) ) {
			return new AFPData( AFPData::DFloat, 0 );
		}

		$nospecials = $this->rmspecials( $s );

		$val = 1. - ( ( mb_strlen( $nospecials ) / mb_strlen( $s ) ) );

		return new AFPData( AFPData::DFloat, $val );
	}

	protected function funcCount( $args ) {
		if ( count( $args ) < 1 ) {
			throw new AFPUserVisibleException(
				'notenoughargs',
				$this->mCur->pos,
				array( 'count', 1, count( $args ) )
			);
		}

		if ( $args[0]->type == AFPData::DList && count( $args ) == 1 ) {
			return new AFPData( AFPData::DInt, count( $args[0]->data ) );
		}

		$offset = - 1;

		if ( count( $args ) == 1 ) {
			$count = count( explode( ',', $args[0]->toString() ) );
		} else {
			$needle = $args[0]->toString();
			$haystack = $args[1]->toString();

			$count = 0;
			while ( ( $offset = strpos( $haystack, $needle, $offset + 1 ) ) !== false ) {
				$count++;
			}
		}

		return new AFPData( AFPData::DInt, $count );
	}

	protected function funcRCount( $args ) {
		if ( count( $args ) < 1 ) {
			throw new AFPUserVisibleException(
				'notenoughargs',
				$this->mCur->pos,
				array( 'rcount', 1, count( $args ) )
			);
		}

		if ( count( $args ) == 1 ) {
			$count = count( explode( ',', $args[0]->toString() ) );
		} else {
			$needle = $args[0]->toString();
			$haystack = $args[1]->toString();

			# Munge the regex
			$needle = preg_replace( '!(\\\\\\\\)*(\\\\)?/!', '$1\/', $needle );
			$needle = "/$needle/u";

			$matches = array();

			$handler = new AFPRegexErrorHandler( $needle, $this->mCur->pos );
			try {
				$handler->install();
				$count = preg_match_all( $needle, $haystack, $matches );
				$handler->restore();
			} catch ( Exception $e ) {
				$handler->restore();
				throw $e;
			}
		}

		return new AFPData( AFPData::DInt, $count );
	}

	protected function funcIPInRange( $args ) {
		if ( count( $args ) < 2 ) {
			throw new AFPUserVisibleException(
				'notenoughargs',
				$this->mCur->pos,
				array( 'ip_in_range', 2, count( $args ) )
			);
		}

		$ip = $args[0]->toString();
		$range = $args[1]->toString();

		$result = IP::isInRange( $ip, $range );

		return new AFPData( AFPData::DBool, $result );
	}

	protected function funcCCNorm( $args ) {
		if ( count( $args ) < 1 ) {
			throw new AFPUserVisibleException(
				'notenoughargs',
				$this->mCur->pos,
				array( 'ccnorm', 1, count( $args ) )
			);
		}
		$s = $args[0]->toString();

		$s = html_entity_decode( $s, ENT_QUOTES, 'UTF-8' );
		$s = $this->ccnorm( $s );

		return new AFPData( AFPData::DString, $s );
	}

	protected function funcContainsAny( $args ) {
		if ( count( $args ) < 2 ) {
			throw new AFPUserVisibleException(
				'notenoughargs',
				$this->mCur->pos,
				array( 'contains_any', 2, count( $args ) )
			);
		}

		$s = array_shift( $args );
		$s = $s->toString();

		$searchStrings = array();

		foreach ( $args as $arg ) {
			$searchStrings[] = $arg->toString();
		}

		if ( function_exists( 'fss_prep_search' ) ) {
			$fss = fss_prep_search( $searchStrings );
			$result = fss_exec_search( $fss, $s );

			$ok = is_array( $result );
		} else {
			$ok = false;
			foreach ( $searchStrings as $needle ) {
				if ( in_string( $needle, $s ) ) {
					$ok = true;
					break;
				}
			}
		}

		return new AFPData( AFPData::DBool, $ok );
	}

	protected function ccnorm( $s ) {
		static $equivset = null;
		static $replacementArray = null;

		if ( is_null( $equivset ) || is_null( $replacementArray ) ) {
			global $IP;
			require_once( "$IP/extensions/AntiSpoof/equivset.php" );
			$replacementArray = new ReplacementArray( $equivset );
		}

		return $replacementArray->replace( $s );
	}

	protected function rmspecials( $s ) {
		$s = preg_replace( '/[^\p{L}\p{N}]/u', '', $s );

		return $s;
	}

	protected function rmdoubles( $s ) {
		return preg_replace( '/(.)\1+/us', '\1', $s );
	}

	protected function rmwhitespace( $s ) {
		return preg_replace( '/\s+/u', '', $s );
	}

	protected function funcRMSpecials( $args ) {
		if ( count( $args ) < 1 ) {
			throw new AFPUserVisibleException(
				'notenoughargs',
				$this->mCur->pos,
				array( 'rmspecials', 1, count( $args ) )
			);
		}
		$s = $args[0]->toString();

		$s = $this->rmspecials( $s );

		return new AFPData( AFPData::DString, $s );
	}

	protected function funcRMWhitespace( $args ) {
		if ( count( $args ) < 1 ) {
			throw new AFPUserVisibleException(
				'notenoughargs',
				$this->mCur->pos,
				array( 'rmwhitespace', 1, count( $args ) )
			);
		}
		$s = $args[0]->toString();

		$s = $this->rmwhitespace( $s );

		return new AFPData( AFPData::DString, $s );
	}

	protected function funcRMDoubles( $args ) {
		if ( count( $args ) < 1 ) {
			throw new AFPUserVisibleException(
				'notenoughargs',
				$this->mCur->pos,
				array( 'rmdoubles', 1, count( $args ) )
			);
		}
		$s = $args[0]->toString();

		$s = $this->rmdoubles( $s );

		return new AFPData( AFPData::DString, $s );
	}

	protected function funcNorm( $args ) {
		if ( count( $args ) < 1 ) {
			throw new AFPUserVisibleException(
				'notenoughargs',
				$this->mCur->pos,
				array( 'norm', 1, count( $args ) )
			);
		}
		$s = $args[0]->toString();

		$s = $this->ccnorm( $s );
		$s = $this->rmdoubles( $s );
		$s = $this->rmspecials( $s );
		$s = $this->rmwhitespace( $s );

		return new AFPData( AFPData::DString, $s );
	}

	protected function funcSubstr( $args ) {
		if ( count( $args ) < 2 ) {
			throw new AFPUserVisibleException(
				'notenoughargs',
				$this->mCur->pos,
				array( 'substr', 2, count( $args ) )
			);
		}

		$s = $args[0]->toString();
		$offset = $args[1]->toInt();

		if ( isset( $args[2] ) ) {
			$length = $args[2]->toInt();

			$result = mb_substr( $s, $offset, $length );
		} else {
			$result = mb_substr( $s, $offset );
		}

		return new AFPData( AFPData::DString, $result );
	}

	protected function funcStrPos( $args ) {
		if ( count( $args ) < 2 ) {
			throw new AFPUserVisibleException(
				'notenoughargs',
				$this->mCur->pos,
				array( 'strpos', 2, count( $args ) )
			);
		}

		$haystack = $args[0]->toString();
		$needle = $args[1]->toString();

		if ( isset( $args[2] ) ) {
			$offset = $args[2]->toInt();

			$result = mb_strpos( $haystack, $needle, $offset );
		} else {
			$result = mb_strpos( $haystack, $needle );
		}

		if ( $result === false )
			$result = - 1;

		return new AFPData( AFPData::DInt, $result );
	}

	protected function funcStrReplace( $args ) {
		if ( count( $args ) < 3 ) {
			throw new AFPUserVisibleException(
				'notenoughargs',
				$this->mCur->pos,
				array( 'str_replace', 3, count( $args ) )
			);
		}

		$subject = $args[0]->toString();
		$search = $args[1]->toString();
		$replace = $args[2]->toString();

		return new AFPData( AFPData::DString, str_replace( $search, $replace, $subject ) );
	}

	protected function funcStrRegexEscape( $args ) {
		if ( count( $args ) < 1 ) {
			throw new AFPUserVisibleException( 'notenoughargs', $this->mCur->pos,
						array( 'rescape', 1, count( $args ) ) );
		}

		$string = $args[0]->toString();

		// preg_quote does not need the second parameter, since rlike takes care of the delimiter symbol itself
		return new AFPData( AFPData::DString, preg_quote( $string ) );
	}

	protected function funcSetVar( $args ) {
		if ( count( $args ) < 2 ) {
			throw new AFPUserVisibleException(
				'notenoughargs',
				$this->mCur->pos,
				array( 'set_var', 2, count( $args ) )
			);
		}

		$varName = $args[0]->toString();
		$value = $args[1];

		$this->setUserVariable( $varName, $value );

		return $value;
	}

	protected function castString( $args ) {
		if ( count( $args ) < 1 ) {
			throw new AFPUserVisibleException( 'noparams', $this->mCur->pos, array( __METHOD__ ) );
		}
		$val = $args[0];

		return AFPData::castTypes( $val, AFPData::DString );
	}

	protected function castInt( $args ) {
		if ( count( $args ) < 1 ) {
			throw new AFPUserVisibleException( 'noparams', $this->mCur->pos, array( __METHOD__ ) );
		}
		$val = $args[0];

		return AFPData::castTypes( $val, AFPData::DInt );
	}

	protected function castFloat( $args ) {
		if ( count( $args ) < 1 ) {
			throw new AFPUserVisibleException( 'noparams', $this->mCur->pos, array( __METHOD__ ) );
		}
		$val = $args[0];

		return AFPData::castTypes( $val, AFPData::DFloat );
	}

	protected function castBool( $args ) {
		if ( count( $args ) < 1 ) {
			throw new AFPUserVisibleException( 'noparams', $this->mCur->pos, array( __METHOD__ ) );
		}
		$val = $args[0];

		return AFPData::castTypes( $val, AFPData::DBool );
	}
}

 # Taken from http://au2.php.net/manual/en/function.fnmatch.php#71725
 # Attribution: jk at ricochetsolutions dot com

if ( !function_exists( 'fnmatch' ) ) {

	function fnmatch( $pattern, $string ) {
		return preg_match( "#^" . strtr( preg_quote( $pattern, '#' ), array( '\*' => '.*', '\?' => '.' ) ) . "$#iu", $string );
	} // end

} // end if
