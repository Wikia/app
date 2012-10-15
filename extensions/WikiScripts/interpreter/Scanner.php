<?php
/**
 * Built-in scripting language for MediaWiki: scanner.
 * Based on the AbuseFilter scanner.
 * Copyright (C) 2008-2011 Victor Vasiliev <vasilvv@gmail.com>, Andrew Garrett <andrew@epstone.net>
 * http://www.mediawiki.org/
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 */

if( !defined( 'MEDIAWIKI' ) )
	die();

/**
 * Lexical analizator for scripts. Splits strings to tokens.
 */

require_once( 'Shared.php' );

class WSScanner implements Iterator {
	var $mModule, $mCode, $mPos, $mCur, $mEof;

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
		'?', '::', ':', 	// Ternery
		'<=','<', 			// Less than
		'>=', '>', 			// Greater than
		'===', '==', '=', 	// Equality
		',', ';',           // Comma, semicolon
		'(', '[', '{',      // Braces
		')', ']', '}',		// Braces
	);

	static $mKeywords = array(
		'append', 'break', 'catch', 'contains', 'continue', 'delete', 'else', 'false', 'for',
		'function', 'if', 'in', 'isset', 'null', 'return', 'self', 'then', 'true', 'try', 'yield',
	);

	public function __construct( $module, $code ) {
		$this->mModule = $module;
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
		if( $this->mEof || ( $this->mCur && $this->mCur->type == WSToken::TEnd ) ) {
			$this->mEof = true;
			return $this->mCur = null;
		}

		wfProfileIn( __METHOD__ );
		list( $val, $type ) = $this->nextToken();

		$lineno = count( explode( "\n", substr( $this->mCode, 0, $this->mPos ) ) );
		wfProfileOut( __METHOD__ );
		return $this->mCur = new WSToken( $type, $val, $lineno );
	}

	private function nextToken() {
		$tok = '';

		// Spaces
		$matches = array();
		if ( preg_match( '/\s+/uA', $this->mCode, $matches, 0, $this->mPos ) )
			$this->mPos += strlen($matches[0]);		

		if( $this->mPos >= strlen($this->mCode) )
			return array( null, WSToken::TEnd );

		// Comments
		if ( substr($this->mCode, $this->mPos, 2) == '/*' ) {
			$this->mPos = strpos( $this->mCode, '*/', $this->mPos ) + 2;
			return self::nextToken();
		}

		if( substr( $this->mCode, $this->mPos, 2 ) == '//' ) {
			$newlinePos = strpos( $this->mCode, "\n", $this->mPos );
			if( $newlinePos === false ) {
				return array( null, WSToken::TEnd );
			} else {
				$this->mPos = $newlinePos + 1;
				return self::nextToken();
			}
		}

		// Strings
		if( $this->mCode[$this->mPos] == '"' || $this->mCode[$this->mPos] == "'" ) {
			$type = $this->mCode[$this->mPos];
			$this->mPos++;
			$strLen = strlen($this->mCode);
			while( $this->mPos < $strLen ) {
				if( $this->mCode[$this->mPos] == $type ) {
					$this->mPos++;
					return array( $tok, WSToken::TString );
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
			throw new WSUserVisibleException( 'unclosedstring', $this->mModule, $this->mPos, array() );
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
						? WSToken::TFloat
						: WSToken::TInt,
				);
			}
		}

		// The rest are considered IDs

		// Regex match > PHP
		$idSymbolRegex = '/[0-9A-Za-z_]+/A';
		$matches = array();

		if ( preg_match( $idSymbolRegex, $this->mCode, $matches, 0, $this->mPos ) ) {
			$tok = $matches[0];

			$type = in_array( $tok, self::$mKeywords )
				? $tok : WSToken::TID;

			$this->mPos += strlen( $tok );
			return array( $tok, $type );
		}

		throw new WSUserVisibleException(
			'unrecognisedtoken', $this->mModule, $this->mPos, array( substr( $this->mCode, $this->mPos ) ) );
	}

	private static function getOperatorType( $op ) {
		switch( $op ) {
			case '::':
				return WSToken::TDoubleColon;
			case ':':
				return WSToken::TColon;
			case ',':
				return WSToken::TComma;
			case '>':
			case '<':
			case '>=':
			case '<=':
				return WSToken::TCompareOperator;
			case '==':
			case '!=':
			case '===':
			case '!==':
				return WSToken::TEqualsToOperator;
			case '!':
				return WSToken::TBoolInvert;
			case '(':
				return WSToken::TLeftBracket;
			case '{':
				return WSToken::TLeftCurly;
			case '[':
				return WSToken::TLeftSquare;
			case '&':
			case '|':
			case '^':
				return WSToken::TLogicalOperator;
			case '*':
			case '/':
			case '%':
				return WSToken::TMulOperator;
			case '**':
				return WSToken::TPow;
			case ')':
				return WSToken::TRightBracket;
			case '}':
				return WSToken::TRightCurly;
			case ']':
				return WSToken::TRightSquare;
			case ';':
				return WSToken::TSemicolon;
			case '=':
			case '+=':
			case '-=':
			case '*=':
			case '/=':
				return WSToken::TSet;
			case '+':
			case '-':
				return WSToken::TSumOperator;
			case '?':
				return WSToken::TTrinary;
			default:
				throw new WSException( "Invalid operator: {$op}" );
		}
	}
}
