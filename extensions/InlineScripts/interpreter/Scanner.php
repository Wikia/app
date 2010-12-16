<?php

/**
 * Lexical analizator for inline scripts. Splits strings to tokens.
 */

require_once( 'Shared.php' );

class ISScanner implements Iterator {
	var $mCode, $mPos, $mCur, $mEof;

	// Order is important. The punctuation-matching regex requires that
	//  ** comes before *, etc. They are sorted to make it easy to spot
	//  such errors.
	static $mOps = array(
		'!==', '!=', '!', 	// Inequality
		'+=', '-=',         // Setting 1
		'*=', '/=',         // Setting 2
		'**', '*', 			// Multiplication/exponentiation
		'/', '+', '-', '%', // Other arithmetic
		'&', '|', '^', 		// Logic
		'?', ':', 			// Ternery
		'<=','<', 			// Less than
		'>=', '>', 			// Greater than
		'===', '==', '=', 	// Equality
		',', ';',           // Comma, semicolon
		'(', '[', '{',      // Braces
		')', ']', '}',		// Braces
	);

	static $mKeywords = array(
		'in', 'true', 'false', 'null', 'contains', 'break',
		'if', 'then', 'else', 'foreach', 'do', 'try', 'catch',
		'continue', 'isset', 'unset',
	);

	public function __construct( $code ) {
		$this->mCode = $code;
		$this->rewind();
	}

	public function rewind() {
		$this->mPos = 0;
		$this->mCur = null;
		$this->mEof = false;
		$this->move();
	}

	public function current() {
		return $this->mCur;
	}

	public function key() {
		return $this->mPos;
	}

	public function next() {
		return $this->move();
	}

	public function valid() {
		return !$this->mEof;
	}

	private function move() {
		if( $this->mEof || ( $this->mCur && $this->mCur->type == ISToken::TEnd ) ) {
			$this->mEof = true;
			return $this->mCur = null;
		}
		list( $val, $type ) = $this->nextToken();

		$lineno = count( explode( "\n", substr( $this->mCode, 0, $this->mPos ) ) );
		return $this->mCur = new ISToken( $type, $val, $lineno );
	}

	private function nextToken() {
		$tok = '';

		// Spaces
		$matches = array();
		if ( preg_match( '/\s+/uA', $this->mCode, $matches, 0, $this->mPos ) )
			$this->mPos += strlen($matches[0]);		

		if( $this->mPos >= strlen($this->mCode) )
			return array( null, ISToken::TEnd );

		// Comments
		if ( substr($this->mCode, $this->mPos, 2) == '/*' ) {
			$this->mPos = strpos( $this->mCode, '*/', $this->mPos ) + 2;
			return self::nextToken();
		}

		// Strings
		if( $this->mCode[$this->mPos] == '"' || $this->mCode[$this->mPos] == "'" ) {
			$type = $this->mCode[$this->mPos];
			$this->mPos++;
			$strLen = strlen($this->mCode);
			while( $this->mPos < $strLen ) {
				if( $this->mCode[$this->mPos] == $type ) {
					$this->mPos++;
					return array( $tok, ISToken::TString );
				}

				// Performance: Use a PHP function (implemented in C)
				//  to scan ahead.
				$addLength = strcspn( $this->mCode, $type."\\", $this->mPos );
				if ($addLength) {
					$tok .= substr( $this->mCode, $this->mPos, $addLength );
					$this->mPos += $addLength;
				} elseif( $this->mCode[$this->mPos] == '\\' ) {
					switch( $this->mCode[$this->mPos + 1] ) {
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
							$chr = substr( $this->mCode, $this->mPos + 2, 2 );
							
							if ( preg_match( '/^[0-9A-Fa-f]{2}$/', $chr ) ) {
								$chr = base_convert( $chr, 16, 10 );
								$tok .= chr($chr);
								$this->mPos += 2; # \xXX -- 2 done later
							} else {
								$tok .= 'x';
							}
							break;
						default:
							$tok .= "\\" . $this->mCode[$this->mPos + 1];
					}
					$this->mPos+=2;
				} else {
					$tok .= $this->mCode[$this->mPos];
					$this->mPos++;
				}
			}
			throw new ISUserVisibleException( 'unclosedstring', $this->mPos, array() );;
		}

		// Find operators
		static $operator_regex = null;
		// Match using a regex. Regexes are faster than PHP
		if (!$operator_regex) {
			$quoted_operators = array();

			foreach( self::$mOps as $op )
				$quoted_operators[] = preg_quote( $op, '/' );
			$operator_regex = '/('.implode('|', $quoted_operators).')/A';
		}

		$matches = array();

		preg_match( $operator_regex, $this->mCode, $matches, 0, $this->mPos );

		if( count( $matches ) ) {
			$tok = $matches[0];
			$this->mPos += strlen( $tok );
			return array( $tok, $this->getOperatorType( $tok ) );
		}

		// Find bare numbers
		$bases = array( 'b' => 2,
						'x' => 16,
						'o' => 8 );
		$baseChars = array(
						2 => '[01]',
						16 => '[0-9A-Fa-f]',
						8 => '[0-8]',
						10 => '[0-9.]',
						);
		$baseClass = '['.implode('', array_keys($bases)).']';
		$radixRegex = "/([0-9A-Fa-f]+(?:\.\d*)?|\.\d+)($baseClass)?/Au";
		$matches = array();

		if ( preg_match( $radixRegex, $this->mCode, $matches, 0, $this->mPos ) ) {
			$input = $matches[1];
			$baseChar = @$matches[2];
			$num = null;
			// Sometimes the base char gets mixed in with the rest of it because
			//  the regex targets hex, too.
			//  This mostly happens with binary
			if (!$baseChar && !empty( $bases[ substr( $input, -1 ) ] ) ) {
				$baseChar = substr( $input, -1, 1 );
				$input = substr( $input, 0, -1 );
			}

			if( $baseChar )
				$base = $bases[$baseChar];
			else
				$base = 10;

			// Check against the appropriate character class for input validation
			$baseRegex = "/^".$baseChars[$base]."+$/";

			if ( preg_match( $baseRegex, $input ) ) {
				if ($base != 10) {
					$num = base_convert( $input, $base, 10 );
				} else {
					$num = $input;
				}

				$this->mPos += strlen( $matches[0] );

				$float = in_string( '.', $input );

				return array(
					$float
						? doubleval( $num )
						: intval( $num ),
					$float
						? ISToken::TFloat
						: ISToken::TInt,
				);
			}
		}

		// The rest are considered IDs

		// Regex match > PHP
		$idSymbolRegex = '/[0-9A-Za-z_]+/A';
		$matches = array();

		if ( preg_match( $idSymbolRegex, $this->mCode, $matches, 0, $this->mPos ) ) {
			$tok = strtolower( $matches[0] );

			$type = in_array( $tok, self::$mKeywords )
				? $tok : ISToken::TID;

			$this->mPos += strlen( $tok );
			return array( $tok, $type );
		}

		throw new ISUserVisibleException(
			'unrecognisedtoken', $this->mPos, array( substr( $this->mCode, $this->mPos ) ) );
	}

	private static function getOperatorType( $op ) {
		switch( $op ) {
			case ':':
				return ISToken::TColon;
			case ',':
				return ISToken::TComma;
			case '>':
			case '<':
			case '>=':
			case '<=':
				return ISToken::TCompareOperator;
			case '==':
			case '!=':
			case '===':
			case '!==':
				return ISToken::TEqualsToOperator;
			case '!':
				return ISToken::TBoolInvert;
			case '(':
				return ISToken::TLeftBrace;
			case '{':
				return ISToken::TLeftCurly;
			case '[':
				return ISToken::TLeftSquare;
			case '&':
			case '|':
			case '^':
				return ISToken::TLogicalOperator;
			case '*':
			case '/':
			case '%':
				return ISToken::TMulOperator;
			case '**':
				return ISToken::TPow;
			case ')':
				return ISToken::TRightBrace;
			case '}':
				return ISToken::TRightCurly;
			case ']':
				return ISToken::TRightSquare;
			case ';':
				return ISToken::TSemicolon;
			case '=':
			case '+=':
			case '-=':
			case '*=':
			case '/=':
				return ISToken::TSet;
			case '+':
			case '-':
				return ISToken::TSumOperator;
			case '?':
				return ISToken::TTrinary;
			default:
				throw new ISException( "Invalid operator: {$op}" );
		}
	}
}
