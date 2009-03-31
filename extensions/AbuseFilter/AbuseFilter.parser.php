<?php
if ( ! defined( 'MEDIAWIKI' ) )
	die();
/**
Abuse filter parser.
Copyright (C) Victor Vasiliev, 2008. Based on ideas by Andrew Garrett Distributed under GNU GPL v2 terms.

Types of token:
* T_NONE - special-purpose token
* T_BRACE  - ( or )
* T_COMMA - ,
* T_OP - operator like + or ^
* T_NUMBER - number
* T_STRING - string, in "" or ''
* T_KEYWORD - keyword
* T_ID - identifier

Levels of parsing:
* Conditionls (IF) - if-then-else-end, cond ? a :b
* BoolOps (BO) - &, |, ^
* CompOps (CO) - ==, !=, ===, !==, >, <, >=, <=
* SumRel (SR) - +, -
* MulRel (MR) - *, /, %
* Pow (P) - **
* BoolNeg (BN) - ! operation
* SpecialOperators (SO) - in and like
* Unarys (U) - plus and minus in cases like -5 or -(2 * +2)
* Braces (B) - ( and )
* Functions (F)
* Atom (A) - return value
*/

class AFPToken {
	//Types of tken
	const TNone = 'T_NONE';
	const TID = 'T_ID';
	const TKeyword = 'T_KEYWORD';
	const TString = 'T_STRING';
	const TInt = 'T_INT';
	const TFloat = 'T_FLOAT';
	const TOp = 'T_OP';
	const TBrace = 'T_BRACE';
	const TComma = 'T_COMMA';
	
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
	//Datatypes
	const DInt = 'int';
	const DString = 'string';
	const DNull   = 'null';
	const DBool   = 'bool';
	const DFloat  = 'float';
	
	var $type;
	var $data;
	
	public function __construct( $type = self::DNull, $val = null ) {
		$this->type = $type;
		$this->data = $val;
	}
	
	public static function newFromPHPVar( $var ) {
		if( is_string( $var ) )
			return new AFPData( self::DString, $var );
		elseif( is_int( $var ) )
			return new AFPData( self::DInt, $var );
		elseif( is_float( $var ) )
			return new AFPData( self::DFloat, $var );
		elseif( is_bool( $var ) )
			return new AFPData( self::DBool, $var );
		elseif( is_null( $var ) )
			return new AFPData();
		else
		throw new AFPException( "Data type " . gettype( $var ) . " is not supported by AbuseFilter" );
	}
	
	public function dup() {
		return new AFPData( $this->type, $this->data );
	}
	
	public static function castTypes( $orig, $target ) {
		if( $orig->type == $target )
			return $orig->dup();
		if( $target == self::DNull ) {
			return new AFPData();
		}
		if( $target == self::DBool ) {
			return new AFPData( self::DBool, (bool)$orig->data );
		}
		if( $target == self::DFloat ) {
			return new AFPData( self::DFloat, doubleval( $orig->data ) );
		}
		if( $target == self::DInt ) {
			return new AFPData( self::DInt, intval( $orig->data ) );
		}
		if( $target == self::DString ) {
			return new AFPData( self::DString, strval( $orig->data ) );
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
		
		if ($a == '' || $b == '') {
			return new AFPData( self::DBool, false );
		}
		
		return new AFPData( self::DBool, in_string( $a, $b ) );
	}
	
	public static function keywordContains( $a, $b ) {
		$a = $a->toString();
		$b = $b->toString();
		
		if ($a == '' || $b == '') {
			return new AFPData( self::DBool, false );
		}
		
		return new AFPData( self::DBool, in_string( $b, $a ) );
	}
	
	public static function keywordLike( $str, $pattern ) {
		$str = $str->toString();
		$pattern = $pattern->toString();
		wfSuppressWarnings();
		$result = fnmatch( $pattern, $str );
		wfRestoreWarnings();
		return new AFPData( self::DBool, (bool)$result );
	}
	
	public static function keywordRegex( $str, $regex ) {
		$str = $str->toString();
		$pattern = $regex->toString();
		
		if (preg_match('/^\/.*\/$/u', $pattern)) {
			$pattern .= 'u';
		} elseif (preg_match( '/^\/.*\/\w+$/u', $pattern ) ) {
			# Nothing
		} else {
			$pattern = "/$pattern/u";
		}
		
		wfSuppressWarnings();
		$result = preg_match( $pattern, $str );
		wfRestoreWarnings();
		return new AFPData( self::DBool, (bool)$result );
	}
	
	public static function unaryMinus( $data ) {
		if ($data->type == self::DInt) {
			return new AFPData( $data->type, -$data->toInt() );
		} else {
			return new AFPData( $data->type, -$data->toFloat() );
		}
	}
	
	public static function boolOp( $a, $b, $op ) {
		$a = $a->toBool();
		$b = $b->toBool();
		if( $op == '|' )
			return new AFPData( self::DBool, $a || $b );
		if( $op == '&' )
			return new AFPData( self::DBool, $a && $b );
		if( $op == '^' )
			return new AFPData( self::DBool, $a xor $b );
		throw new AFPException( "Invalid boolean operation: {$op}" );
	}
	
	public static function compareOp( $a, $b, $op ) {
		if( $op == '==' || $op == '=' )
			return new AFPData( self::DBool, $a->toString() === $b->toString() );
		if( $op == '!=' )
			return new AFPData( self::DBool, $a->toString() !== $b->toString() );
		if( $op == '===' )
			return new AFPData( self::DBool, $a->data == $b->data && $a->type == $b->type );
		if( $op == '!==' )
			return new AFPData( self::DBool, $a->data !== $b->data || $a->type != $b->type );
		$a = $a->toString();
		$b = $b->toString();
		if( $op == '>' )
			return new AFPData( self::DBool, $a > $b );
		if( $op == '<' )
			return new AFPData( self::DBool, $a < $b );
		if( $op == '>=' )
			return new AFPData( self::DBool, $a >= $b );
		if( $op == '<=' )
			return new AFPData( self::DBool, $a <= $b );
		throw new AFPException( "Invalid comprasion operation: {$op}" );
	}
	
	public static function mulRel( $a, $b, $op ) {	
		// Figure out the type.
		if ($a->type == self::DFloat || $b->type == self::DFloat ||
			$a->toFloat() != $a->toString() || $b->toFloat() != $b->toString() ) {
			$type = self::DFloat;
			$a = $a->toFloat();
			$b = $b->toFloat();
		} else {
			$type = self::DInt;
			$a = $a->toInt();
			$b = $b->toInt();
		}
		
		if( $op == '*' )
			$data = $a * $b;
		if( $op == '/' )
			$data = $a / $b;
		if( $op == '%' )
			$data = $a % $b;
			
		if (!$data)
			throw new AFPException( "Invalid multiplication-related operation: {$op}" );
			
		if ($type == self::DInt)
			$data = intval($data);
		else
			$data = doubleval($data);
		
		return new AFPData( $type, $data );
	}
	
	public static function sum( $a, $b ) {
		if( $a->type == self::DString || $b->type == self::DString )
			return new AFPData( self::DFloat, $a->toString() . $b->toString() );
		else
			return new AFPData( self::DFloat, $a->toFloat() + $b->toFloat() );
	}
	
	public static function sub( $a, $b ) {
		return new AFPData( self::DFloat, $a->toFloat() - $b->toFloat() );
	}
	
	/** Convert shorteners */
	public function toBool() {
		return self::castTypes( $this, self::DBool )->data;
	}
	
	public function toString() {
		return self::castTypes( $this, self::DString )->data;
	}
	
	public function toFloat() {
		return self::castTypes( $this, self::DFloat )->data;
	}
	
	public function toInt() {
		return self::castTypes( $this, self::DInt )->data;
	}
}

class AFPException extends MWException {}
	
class AbuseFilterParser {
	var $mParams, $mVars, $mCode, $mTokens, $mPos, $mCur;
	
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
	'count' => 'funcCount'
	);
	static $mOps = array(
	'!', '*', '**', '/', '+', '-', '%', '&', '|', '^', '?',
	'<', '>', '>=', '<=', '==', '!=', '=',  '===', '!==', ':',
	);
	static $mKeywords = array(
	'in', 'like', 'true', 'false', 'null', 'contains', 'matches',
	'rlike', 'regex', 'if', 'then', 'else', 'end',
	);
	
	static $parserCache = array();
	
	static $funcCache = array();
	
	public function __construct() {
		$this->resetState();
	}
	
	public function resetState() {
		$this->mParams = array();
		$this->mCode = '';
		$this->mTokens = array();
		$this->mVars = array();
		$this->mPos = 0;
	}
	
	public function checkSyntax( $filter ) {
		try {
			$this->parse($filter);
		} catch (AFPException $excep) {
			return $excep->getMessage();
		}
		return true;
	}
	
	public function setVar( $name, $var ) {
		$this->mVars[$name] = AFPData::newFromPHPVar( $var );
	}
	
	public function setVars( $vars ) {
		wfProfileIn( __METHOD__ );
		foreach( $vars as $name => $var ) {
			$this->setVar( $name, $var );
		}
		wfProfileOut( __METHOD__ );
	}
	
	protected function move( $shift = +1 ) {
		$old = $this->mPos;
		$this->mPos += $shift;
		if( $this->mPos >= 0 && $this->mPos < count( $this->mTokens ) ) {
			$this->mCur = $this->mTokens[$this->mPos];
			return true;
		}
		else {
			$this->mPos = $old;
			return false;
		}
	}
	
	public function parse( $code ) {
		return $this->intEval( $code )->toBool();
	}
	
	public function evaluateExpression( $filter ) {
		return $this->intEval( $filter )->toString();
	}
	
	function intEval( $code ) {
		wfProfileIn( __METHOD__ );
		$this->mCode = $code;
		$this->mTokens = self::parseTokens( $code );
		$this->mPos = 0;
		$this->mCur = $this->mTokens[0];
		$result = new AFPData();
		$this->doLevelEntry( $result );
		wfProfileOut( __METHOD__ );
		return $result;
	}
	
	/* Levels */
	
	/** Handles unexpected characters after the expression */
	protected function doLevelEntry( &$result ) {
		$this->doLevelSet( $result );
		if( $this->mCur->type != AFPToken::TNone ) {
			throw new AFPException( "Unexpected {$this->mCur->type} at char {$this->mCur->pos}" );
		}
	}
	
	/** Handles "=" operator */
	protected function doLevelSet( &$result ) {
		$this->doLevelConditions( $result );
	}

	protected function doLevelConditions( &$result ) {
		if( $this->mCur->type == AFPToken::TKeyword && $this->mCur->value == 'if' ) {
			$this->move();
			$this->doLevelBoolOps( $result );
			if( !($this->mCur->type == AFPToken::TKeyword && $this->mCur->value == 'then') )
				throw new AFPException( "Excepted \"then\" at char {$this->mCur->pos}" );
			$this->move();
			$r1 = new AFPData();
			$r2 = new AFPData();
			$this->doLevelConditions( $r1 );
			if( !($this->mCur->type == AFPToken::TKeyword && $this->mCur->value == 'else') )
				throw new AFPException( "Excepted \"else\" at char {$this->mCur->pos}" );
			$this->move();
			$this->doLevelConditions( $r2 );
			if( $result->toBool() ) {
				$result = $r1;
			} else {
				$result = $r2;
			}
			if( !($this->mCur->type == AFPToken::TKeyword && $this->mCur->value == 'end') )
				throw new AFPException( "Excepted \"else\" at char {$this->mCur->pos}" );
			$this->move();
		} else {
			$this->doLevelBoolOps( $result );
			if( $this->mCur->type == AFPToken::TOp && $this->mCur->value == '?' ) {
				$this->move();
				$r1 = new AFPData();
				$r2 = new AFPData();
				$this->doLevelConditions( $r1 );
				if( !($this->mCur->type == AFPToken::TOp && $this->mCur->value == ':') )
					throw new AFPException( "Excepted \":\" at char {$this->mCur->pos}" );
				$this->move();
				$this->doLevelConditions( $r2 );
				if( $result->toBool() ) {
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
		while( $this->mCur->type == AFPToken::TOp && in_array( $this->mCur->value, $ops ) ) {
			$op = $this->mCur->value;
			$this->move();
			$r2 = new AFPData();
			$this->doLevelCompares( $r2 );
			wfProfileIn( __METHOD__ );
			$result = AFPData::boolOp( $result, $r2, $op );
			wfProfileOut( __METHOD__ );
		}
	}
	
	protected function doLevelCompares( &$result ) {
		$this->doLevelSumRels( $result );
		$ops = array( '==', '===', '!=', '!==', '<', '>', '<=', '>=', '=' );
		while( $this->mCur->type == AFPToken::TOp && in_array( $this->mCur->value, $ops ) ) {
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
		while( $this->mCur->type == AFPToken::TOp && in_array( $this->mCur->value, $ops ) ) {
			$op = $this->mCur->value;
			$this->move();
			$r2 = new AFPData();
			$this->doLevelMulRels( $r2 );
			if( $op == '+' )
				$result = AFPData::sum( $result, $r2 );
			if( $op == '-' )
				$result = AFPData::sub( $result, $r2 );
		}
		wfProfileOut( __METHOD__ );
	}

	protected function doLevelMulRels( &$result ) {
		$this->doLevelPow( $result );
		wfProfileIn( __METHOD__ );
		$ops = array( '*', '/', '%' );
		while( $this->mCur->type == AFPToken::TOp && in_array( $this->mCur->value, $ops ) ) {
			$op = $this->mCur->value;
			$this->move();
			$r2 = new AFPData();
			$this->doLevelPow( $r2 );
			$result = AFPData::mulRel( $result, $r2, $op );
		}
		wfProfileOut( __METHOD__ );
	}

	protected function doLevelPow( &$result ) {
		$this->doLevelBoolInvert( $result );
		wfProfileIn( __METHOD__ );
		while( $this->mCur->type == AFPToken::TOp && $this->mCur->value == '**' ) {
			$this->move();
			$expanent = new AFPData();
			$this->doLevelBoolInvert( $expanent );
			$result = AFPData::pow( $result, $expanent );
		}
		wfProfileOut( __METHOD__ );
	}
	
	protected function doLevelBoolInvert( &$result ) {
		if( $this->mCur->type == AFPToken::TOp && $this->mCur->value == '!' ) {
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
		$specwords = array( 'in' => 'keywordIn', 'like' => 'keywordLike', 'matches' => 'keywordLike', 'contains' => 'keywordContains', 'rlike' => 'keywordRegex', 'regex' => 'keywordRegex' );
		if( $this->mCur->type == AFPToken::TKeyword && in_array( $this->mCur->value, array_keys($specwords) ) ) {
			$func = $specwords[$this->mCur->value];
			$this->move();
			$r2 = new AFPData();
			$this->doLevelUnarys( $r2 );
			wfProfileIn( __METHOD__ );
			wfProfileIn( __METHOD__."-$func" );
			$result = AFPData::$func( $result, $r2 );
			wfProfileOut( __METHOD__."-$func" );
			wfProfileOut( __METHOD__ );
		}
	}
	
	protected function doLevelUnarys( &$result ) {
		$op = $this->mCur->value;
		if( $this->mCur->type == AFPToken::TOp && ( $op == "+" || $op == "-" ) ) {
			$this->move();
			$this->doLevelBraces( $result );
			wfProfileIn( __METHOD__ );
			if( $op == '-' ) {
				$result = AFPData::unaryMinus( $result );
			}
			wfProfileOut( __METHOD__ );
		} else {
			$this->doLevelBraces( $result );
		}
	}
	
	protected function doLevelBraces( &$result ) {
		if( $this->mCur->type == AFPToken::TBrace && $this->mCur->value == '(' ) {
			$this->move();
			$this->doLevelSet( $result );
			if( !($this->mCur->type == AFPToken::TBrace && $this->mCur->value == ')') )
				throw new AFPException( "Expected ) at char {$this->mCur->pos}" );
			$this->move();
		} else {
			$this->doLevelFunction( $result );
		}
	}
	
	protected function doLevelFunction( &$result ) {
		if( $this->mCur->type == AFPToken::TID && isset( self::$mFunctions[$this->mCur->value] ) ) {
			wfProfileIn( __METHOD__ );
			$func = self::$mFunctions[$this->mCur->value];
			$this->move();
			if( $this->mCur->type != AFPToken::TBrace || $this->mCur->value != '(' )
				throw new AFPEexception( "Expected ( at char {$this->mCur->value}" );
			wfProfileIn( __METHOD__."-loadargs" );
			$args = array();
			if( $this->mCur->type != AFPToken::TBrace || $this->mCur->value != ')' )
				do {
					$this->move();
					$r = new AFPData();
					try {
						$this->doLevelAtom( $r );
					} catch (AFPException $e) {
						$this->move( -1 );
						$this->doLevelSet( $r );
					}
					$args[] = $r;
				} while( $this->mCur->type == AFPToken::TComma );
			
			if( $this->mCur->type != AFPToken::TBrace || $this->mCur->value != ')' ) {
				throw new AFPException( "Expected ) at char {$this->mCur->pos}" );
			}
			wfProfileOut( __METHOD__."-loadargs" );
			
			wfProfileIn( __METHOD__."-$func" );
			
			$funcHash = md5($func.serialize($args));
			
			if (isset(self::$funcCache[$funcHash])) {
				$result = self::$funcCache[$funcHash];
			} else {
				$result = self::$funcCache[$funcHash] = $this->$func( $args );
			}
			
			if (count(self::$funcCache) > 1000) {
				self::$funcCache = array();
			}
			
			wfProfileOut( __METHOD__."-$func" );
			
			$this->move();
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
				if( isset( $this->mVars[$tok] ) ) {
					$result = $this->mVars[$tok];
				} else {
					$result = new AFPData();
				}
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
				if( $tok == "true" )
					$result = new AFPData( AFPData::DBool, true );
				elseif( $tok == "false" )
					$result = new AFPData( AFPData::DBool, false );
				elseif( $tok == "null" )
					$result = new AFPData();
				else
					throw new AFPException( "Unexpected {$this->mCur->type} at char {$this->mCur->pos}" );
				break;
			case AFPToken::TBrace:
			if( $this->mCur->value == ')' )
				return;        // Handled at the entry level
			default:
				throw new AFPException( "Unexpected {$this->mCur->type} at char {$this->mCur->pos}" );
		}
		$this->move();
		wfProfileOut( __METHOD__ );
	}
	
	/* End of levels */
	
	public static function parseTokens( $code ) {
		$r = array();
		$len = strlen( $code );
		$hash = md5(trim($code));
		
		if (isset(self::$parserCache[$hash])) {
			return self::$parserCache[$hash];
		}
		
		while( $tok = self::nextToken( $code, $len ) ) {
			list( $val, $type, $code, $pos ) = $tok;
			$r[] = new AFPToken( $type, $val, $pos );
			if( $type == AFPToken::TNone )
			break;
		}
		
		return self::$parserCache[$hash] = $r;
	}
	
	protected static function nextToken( $code, $len ) {
		$tok = '';
		
		if( strlen( $code ) == 0 ) return array( '', AFPToken::TNone, $code, $len );
		
		while( ctype_space( $code[0] ) )
			$code = substr( $code, 1 );
		
		$pos = $len - strlen( $code );
		
		if( strlen( $code ) == 0 ) return array( '', AFPToken::TNone, $code, $pos );

		if ( substr($code,0,2) == '/*' ) {
			// Comments
			$last = '/*';
			while ($last != '*/') {
				$code = substr($code,1);
				$last[0] = $last[1];
				$last[1] = $code[0];
			}
			$code = substr( $code, 1 );
			
			return self::nextToken( $code, $len );
		}
		
		if( $code[0] == ',' )
			return array( ',', AFPToken::TComma, substr( $code, 1 ), $pos );
		
		if( $code[0] == '(' or $code[0] == ')' )
			return array( $code[0], AFPToken::TBrace, substr( $code, 1 ), $pos );
			
		if( $code[0] == '"' || $code[0] == "'" ) {
			$type = $code[0];
			$code = substr( $code, 1 );
			while( strlen( $code ) != 0 ) {
				if( $code[0] == $type ) {
					return array( $tok, AFPToken::TString, substr( $code, 1 ), $pos );
				}
				if( $code[0] == '\\' ) {
					if( $code[1] == '\\' )
						$tok .= '\\';
					elseif( $code[1] == $type )
						$tok .= $type;
					elseif( $code[1] == 'n' )
						$tok .= "\n";
					elseif( $code[1] == 'r' )
						$tok .= "\r";
					elseif( $code[1] == 't' )
						$tok .= "\t";
					elseif( $code[1] == 'x' ) {
						$chr = substr($code,2,2);
						$chr = wfBaseConvert( $chr, 16, 10 );
						$tok .= chr($chr);
						$code = substr( $code, 2 );
					}
					else
						$tok .= $code[1];
					$code = substr( $code, 2 );
				} else {
					$tok .= $code[0];
					$code = substr( $code, 1 );
				}
			}
			throw new AFPException( "Unclosed string begining at char $pos" );
		}
		
		$bases = array( 'b' => 2, 'x' => 16, 'o' => 8 );
		$baseClass = '['.implode('', array_keys($bases)).']';
		$radixRegex = "/^[0-9A-Fa-f]+$baseClass\b/u";
		if( ctype_digit($code[0]) || ( self::isDigitOrDot( $code[0] ) && ctype_digit( $code[1] ) ) || preg_match( $radixRegex, $code ) ) {
			$tok .= $code[0];
			$code = substr( $code, 1 );
			
			$base = '';
			
			while( strlen( $code ) != 0 && self::isDigitOrDot( $code[0] ) ) {
				$tok .= $base = $code[0];
				$code = substr( $code, 1 );
			}
			
			if ($base && isset($bases[$base]) ) {
				$tok = substr( $tok, 0, -1 );
				
				$base = $bases[$base];
				
				$code = substr( $code, 1 );
				
				$tok = wfBaseConvert( $tok, $base, 10 );
			}
			
			$float = in_string( '.', $tok );
			
			if (strlen($tok))
				return array( $float ? doubleval( $tok ) : intval( $tok ), $float ? AFPToken::TFloat : AFPToken::TInt, $code, $pos );
		}
		
		if( ctype_punct( $code[0] ) ) {
			$tok .= $code[0];
			$code = substr( $code, 1 );
			while( strlen( $code ) != 0 && ctype_punct( $code[0] ) ) {
				$tok .= $code[0];
				$code = substr( $code, 1 );
			}
			if( !in_array( $tok, self::$mOps ) )
			throw new AFPException( "Invalid operator: {$tok} (at char $pos)" );
			return array( $tok, AFPToken::TOp, $code, $pos );
		}
		
		if( self::isValidIdSymbol( $code[0] ) ) {
			while( strlen( $code ) != 0 && self::isValidIdSymbol( $code[0] ) ) {
				$tok .= $code[0];
				$code = substr( $code, 1 );
			}
			$type = in_array( $tok, self::$mKeywords ) ? AFPToken::TKeyword : AFPToken::TID;
			return array( $tok, $type, $code, $pos );
		}
		
		throw new AFPException( "Unrecognized token \"{$code[0]}\" at char $pos" );
	}
	
	protected static function isDigitOrDot( $chr ) {
		return ctype_alnum( $chr ) || $chr == '.';
	}
	
	protected static function isValidIdSymbol( $chr ) {
		return ctype_alnum( $chr ) || $chr == '_';
	}
	
	//Built-in functions
	protected function funcLc( $args ) {
		global $wgContLang;
		if( count( $args ) < 1 )
			throw new AFPExpection( "No params passed to lc()" );
		$s = $args[0]->toString();
		return new AFPData( AFPData::DString, $wgContLang->lc( $s ) );
	}
	
	protected function funcLen( $args ) {
		if( count( $args ) < 1 )
			throw new AFPExpection( "No params passed to len()" );
		$s = $args[0]->toString();
		return new AFPData( AFPData::DInt, mb_strlen( $s, 'utf-8' ) );
	}
	
	protected function funcSimpleNorm( $args ) {
		if( count( $args ) < 1 )
			throw new AFPExpection( "No params passed to simplenorm()" );
		$s = $args[0]->toString();
		
		$s = preg_replace( '/[\d\W]+/', '', $s );
		$s = strtolower( $value );
		return new AFPData( AFPData::DString, $s );
	}
	
	protected function funcSpecialRatio( $args ) {
		if( count( $args ) < 1 )
			throw new AFPExpection( "No params passed to specialratio()" );
		$s = $args[0]->toString();
		
		if (!strlen($s)) {
			return new AFPData( AFPData::DFloat, 0 );
		}
		
		$nospecials = $this->rmspecials( $s );
		
		$val = 1. - ((mb_strlen($nospecials) / mb_strlen($s)));
		
		return new AFPData( AFPData::DFloat, $val );
	}
	
	protected function funcCount( $args ) {
		if( count( $args ) < 1 )
			throw new AFPExpection( "No params passed to ".__METHOD__ );
			
		$offset = -1;
		
		if (count($args) == 1) {
			$count = count( explode( ",", $args[0]->toString() ) );
		} else {
			$needle = $args[0]->toString();
			$haystack = $args[1]->toString();
			
			$count = 0;
			while ( ($offset = strpos( $haystack, $needle, $offset + 1 )) !== false ) {
				$count++;
			}
		}
		
		return new AFPData( AFPData::DInt, $count );
	}
	
	protected function funcCCNorm( $args ) {
		if( count( $args ) < 1 )
			throw new AFPExpection( "No params passed to ".__METHOD__ );
		$s = $args[0]->toString();
		
		$s = $this->ccnorm( $s );
		
		return new AFPData( AFPData::DString, $s );
	}
	
	protected function ccnorm( $s ) {
		if (!class_exists( 'AntiSpoof' ) ) {
			return $s;
		}
		
		// Normalise confusable characters.
		$chars = AntiSpoof::stringToList( $s );
		$chars = AntiSpoof::equivString( $chars );
		$s = AntiSpoof::listToString( $chars );
		
		return $s;
	}
	
	protected function rmspecials( $s ) {
		$orig = $s;
		$s = preg_replace( '/[^\p{L}\p{N}]/u', '', $s );
		
		return $s;
	}
	
	protected function rmdoubles( $s ) {
		$last = -1;
		$ret = array();
		
		$chars = AntiSpoof::stringToList( $s );
		
		foreach( $chars as $char) {
			if ($char != $last)
				$ret[] = $char;
			$last = $char;
		}
		
		return AntiSpoof::listToString($ret);
	}
	
	protected function funcRMSpecials( $args ) {
		if( count( $args ) < 1 )
			throw new AFPExpection( "No params passed to ".__METHOD__ );
		$s = $args[0]->toString();
		
		$s = $this->rmspecials( $s );
		
		return new AFPData( AFPData::DString, $s );
	}
	
	protected function funcRMDoubles( $args ) {
		if( count( $args ) < 1 )
			throw new AFPExpection( "No params passed to ".__METHOD__ );
		$s = $args[0]->toString();
		
		$s = $this->rmdoubles( $s );
		
		return new AFPData( AFPData::DString, $s );
	}
	
	protected function funcNorm( $args ) {
		if( count( $args ) < 1 )
			throw new AFPExpection( "No params passed to ".__METHOD__ );
		$s = $args[0]->toString();
		
		$s = $this->ccnorm($s);
		$s = $this->rmdoubles( $s );
		$s = $this->rmspecials( $s );
		
		return new AFPData( AFPData::DString, $s );
	}
	
	protected function castString( $args ) {
		if ( count( $args ) < 1)
			throw new AFPException( "No params passed to ".__METHOD__ );
		$val = $args[0];
		
		return new AFPData( AFPData::DString, $val->data );
	}
	
	protected function castInt( $args ) {
		if ( count( $args ) < 1)
			throw new AFPException( "No params passed to ".__METHOD__ );
		$val = $args[0];
		
		return new AFPData( AFPData::DInt, intval($val->data) );
	}

	protected function castFloat( $args ) {
		if ( count( $args ) < 1)
			throw new AFPException( "No params passed to ".__METHOD__ );
		$val = $args[0];
		
		return new AFPData( AFPData::DFloat, doubleval($val->data) );
	}
	
	protected function castBool( $args ) {
		if ( count( $args ) < 1)
			throw new AFPException( "No params passed to ".__METHOD__ );
		$val = $args[0];
		
		return new AFPData( AFPData::DBool, (bool)($val->data) );
	}
}

 ## Taken from http://au2.php.net/manual/en/function.fnmatch.php#71725
 ### Attribution: jk at ricochetsolutions dot com

if(!function_exists('fnmatch')) {

    function fnmatch($pattern, $string) {
        return preg_match("#^".strtr(preg_quote($pattern, '#'), array('\*' => '.*', '\?' => '.'))."$#i", $string);
    } // end

} // end if