#!/usr/bin/env php
<?php

/**
 * A PHP code beautifier aimed at adding lots of spaces to files that lack them,
 * in keeping with MediaWiki's spacey site style.
 *
 * @author Tim Starling
 * @author Jeroen De Dauw
 */

if ( php_sapi_name() != 'cli' ) {
	echo "This script must be run from the command line\n";
	exit( 1 );
}

array_shift( $argv );

if ( count( $argv ) ) {
	$args = new Args( $argv );

	if ( $args->flag( 'help' ) ) {
		echo "Usage: php stylize.php [--backup|--help|--ignore=<regextoexclude>] <files/directories>
	backup : Creates a backup of modified files
	help : This message!
	ignore : Regex of files not to stylize e.g. .*\.i18n\.php
	<files/directories> : Files/directories to stylize
";

		return;
	}

	$ignore = $args->flag( 'ignore' );
	$backup = $args->flag( 'backup' );

	foreach ( $args->args as $dirOrFile ) {
		if ( is_dir( $dirOrFile ) ) {
			stylize_recursively( $dirOrFile, $ignore, $backup );
		} else {
			stylize_file( $dirOrFile, $backup );
		}
	}
} else {
	stylize_file( '-' );
}

function stylize_recursively( $dir, $ignore = false, $backup = false ) {
	$dir = trim( $dir, "\/" );

	foreach ( glob( "$dir/*" ) as $dirOrFile ) {
		if ( $ignore && preg_match( '/' . $ignore . '$/', $dirOrFile ) ) {
			echo "Ignoring $dirOrFile\n";
			continue;
		}

		if ( is_dir( $dirOrFile ) ) { // It's a directory, so call this function again.
			stylize_recursively( $dirOrFile, $ignore, $backup );
		} elseif ( is_file( $dirOrFile ) ) { // It's a file, so let's stylize it.
			// Only stylize php and js files, omitting minified js files.
			if ( preg_match( '/\.(php|php5|js)$/', $dirOrFile ) && !preg_match( '/\.(min\.js)$/', $dirOrFile ) ) {
				stylize_file( $dirOrFile, $backup );
			}
		}
	}
}

function stylize_file( $filename, $backup = true ) {
	echo "Stylizing file $filename\n";

	$s = ( $filename == '-' )
		? file_get_contents( '/dev/stdin' )
		: file_get_contents( $filename );

	if ( $s === false ) {
		return;
	}

	$stylizer = new Stylizer( $s );
	$s = $stylizer->stylize();

	if ( $filename == '-' ) {
		echo $s;
	} else {
		if ( $backup ) {
			rename( $filename, "$filename~" );
		}
		file_put_contents( $filename, $s );
	}
}

class Stylizer {
	var $tokens, $p;

	static $tablesInitialised = false;
	static $xSpaceBefore, $xSpaceAfter;

	static $space = array(
		T_WHITESPACE,
		'START',
		'END',
	);
	static $spaceBothSides = array(
		T_AND_EQUAL,
		T_AS,
		T_BOOLEAN_AND,
		T_BOOLEAN_OR,
		T_CASE,
		T_CATCH,
		T_CLONE,
		T_CONCAT_EQUAL,
		T_DIV_EQUAL,
		T_DO,
		T_DOUBLE_ARROW,
		T_ELSE,
		T_ELSEIF,
		T_FOR,
		T_FOREACH,
		T_IF,
		T_IS_EQUAL,
		T_IS_GREATER_OR_EQUAL,
		T_IS_IDENTICAL,
		T_IS_NOT_EQUAL,
		T_IS_NOT_IDENTICAL,
		T_IS_SMALLER_OR_EQUAL,
		T_LOGICAL_AND,
		T_LOGICAL_OR,
		T_LOGICAL_XOR,
		T_MOD_EQUAL,
		T_MUL_EQUAL,
		T_OR_EQUAL,
		T_PLUS_EQUAL,
		T_SL,
		T_SL_EQUAL,
		T_SR,
		T_SR_EQUAL,
		T_TRY,
		T_WHILE,
		T_XOR_EQUAL,
		'{',
		'}',
		'%',
		'^',
		// '&', can be unary, we have a special case for =&
		'*',
		'=',
		'+',
		'|',
		// ':', can be a case label
		'.',
		'<',
		'>',
		'/',
		'?',
	);
	static $spaceBefore = array(
		')',
		'-', // $foo = -1; shouldn't change to $foo = - 1;
	);
	static $spaceAfter = array(
		'(',
		';',
		',',
	);
	static $closePairs = array(
		'(' => ')',
		'=' => '&',
		'{' => '}',
	);

	// Tokens that eat spaces after them
	static $spaceEaters = array(
		T_COMMENT,
		T_OPEN_TAG,
		T_OPEN_TAG_WITH_ECHO,
	);

	var $endl = "
";

	function __construct( $s ) {
		$s = str_replace( "\r\n", "\n", $s );
		$this->tokens = token_get_all( $s );
		if ( !self::$tablesInitialised ) {
			self::$xSpaceBefore = array_combine(
				array_merge( self::$spaceBefore, self::$spaceBothSides ),
				array_fill( 0, count( self::$spaceBefore ) + count( self::$spaceBothSides ), true )
			);
			self::$xSpaceAfter = array_combine(
				array_merge( self::$spaceAfter, self::$spaceBothSides ),
				array_fill( 0, count( self::$spaceAfter ) + count( self::$spaceBothSides ), true )
			);
		}
	}

	function get( $i ) {
		if ( $i < 0 ) {
			return array( 'START', '' );
		} elseif ( $i >= count( $this->tokens ) ) {
			return array( 'END', '' );
		} else {
			$token = $this->tokens[$i];
			if ( is_string( $token ) ) {
				return array( $token, $token );
			} else {
				return array( $token[0], $token[1] );
			}
		}
	}

	function getCurrent() {
		return $this->get( $this->p );
	}

	function getPrev() {
		return $this->get( $this->p - 1 );
	}

	function getNext() {
		return $this->get( $this->p + 1 );
	}

	function isSpace( $token ) {
		if ( in_array( $token[0], self::$space ) ) {
			return true;
		}
		// Some other tokens can eat whitespace
		if ( in_array( $token[0], self::$spaceEaters ) && preg_match( '/\s$/', $token[1] ) ) {
			return true;
		}
		return false;
	}

	function isSpaceBefore( $token ) {
		return isset( self::$xSpaceBefore[$token[0]] );
	}

	function isSpaceAfter( $token ) {
		return isset( self::$xSpaceAfter[$token[0]] );
	}

	function consumeUpTo( $endType ) {
		$token = $this->getCurrent();
		$out = $token[1];
		do {
			$this->p++;
			$token = $this->getCurrent();
			$out .= $token[1];
		} while ( $this->p < count( $this->tokens ) && $token[0] != $endType );
		return $out;
	}

	function stylize() {
		$out = '';
		for ( $this->p = 0; $this->p < count( $this->tokens ); $this->p++ ) {
			list( $prevType, $prevText ) = $prevToken = $this->getPrev();
			list( $curType, $curText ) = $curToken = $this->getCurrent();
			list( $nextType, $nextText ) = $nextToken = $this->getNext();

			// Don't format strings
			if ( $curType == '"' ) {
				$out .= $this->consumeUpTo( '"' );
				continue;
			} elseif ( $curType == T_START_HEREDOC ) {
				$out .= $this->consumeUpTo( T_END_HEREDOC );
				continue;
			} elseif ( $curType == "'" ) {
				// For completeness
				$out .= $this->consumeUpTo( "'" );
				continue;
			}

			// Detect close pairs like ()
			$closePairBefore = isset( self::$closePairs[$prevType] )
				&& $curType == self::$closePairs[$prevType];
			$closePairAfter = isset( self::$closePairs[$curType] )
				&& $nextType == self::$closePairs[$curType];

			// Add space before
			if ( $this->isSpaceBefore( $curToken )
				&& !$this->isSpace( $prevToken )
				&& !$closePairBefore
			) {
					$out .= ' ';
			}

			// Add the token contents
			if ( $curType == T_COMMENT ) {
				$curText = $this->fixComment( $curText );
			}

			$out .= $curText;

			if ( substr( $out, -1 ) === "\n" ) {
				$out = $this->fixWhitespace( $out );
			}

			$wantSpaceAfter = $this->isSpaceAfter( $curToken );
			// Special case: space after =&
			if ( $prevType == '=' && $curType == '&' ) {
				$wantSpaceAfter = true;
			}

			// Add space after
			if ( $wantSpaceAfter
				&& !$closePairAfter
				&& !$this->isSpace( $nextToken )
				&& !$this->isSpaceBefore( $nextToken )
			) {
				$out .= ' ';
			}
		}
		$out = str_replace( "\n", $this->endl, $out );
		return $out;
	}

	function fixComment( $s ) {
		// Fix single-line comments with no leading whitespace
		if ( preg_match( '!^(#++|//++)(\S.*)$!s', $s, $m ) ) {
			$s = $m[1] . ' ' . $m[2];
		}
		return $s;
	}

	function fixWhitespace( $s ) {
		// Fix whitespace at the line end
		return preg_replace( "#[\t ]*\n#", "\n", $s );
	}
}

/**
 * From
 * http://code.google.com/p/tylerhall/source/browse/trunk/class.args.php
 * http://clickontyler.com/blog/2008/11/parse-command-line-arguments-in-php/ - MIT License

  Copyright (c) 2008 Tyler Hall

 Permission is hereby granted, free of charge, to any person obtaining a copy
 of this software and associated documentation files (the "Software"), to deal
 in the Software without restriction, including without limitation the rights
 to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 copies of the Software, and to permit persons to whom the Software is
 furnished to do so, subject to the following conditions:

 The above copyright notice and this permission notice shall be included in
 all copies or substantial portions of the Software.

 THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 THE SOFTWARE
 */
class Args {
	private $flags;
	public $args;

	public function __construct( $argv ) {
		$this->flags = array();
		$this->args  = array();

		for ( $i = 0; $i < count( $argv ); $i++ ) {
			$str = $argv[$i];

			// --foo
			if ( strlen( $str ) > 2 && substr( $str, 0, 2 ) == '--' ) {
				$str = substr( $str, 2 );
				$parts = explode( '=', $str );
				$this->flags[$parts[0]] = true;

				// Does not have an =, so choose the next arg as its value
				if ( count( $parts ) == 1 && isset( $argv[$i + 1] ) && preg_match( '/^--?.+/', $argv[$i + 1] ) == 0 ) {
					$this->flags[$parts[0]] = $argv[$i + 1];
				} elseif ( count( $parts ) == 2 ) { // Has a =, so pick the second piece
					$this->flags[$parts[0]] = $parts[1];
				}
			} elseif ( strlen( $str ) == 2 && $str[0] == '-' ) { // -a
				$this->flags[$str[1]] = true;
				if ( isset( $argv[$i + 1] ) && preg_match( '/^--?.+/', $argv[$i + 1] ) == 0 )
					$this->flags[$str[1]] = $argv[$i + 1];
			} elseif ( strlen( $str ) > 1 && $str[0] == '-' ) { // -abcdef
				for ( $j = 1; $j < strlen( $str ); $j++ )
					$this->flags[$str[$j]] = true;
			}
		}

		for ( $i = count( $argv ) - 1; $i >= 0; $i-- ) {
			if ( preg_match( '/^--?.+/', $argv[$i] ) == 0 )
				$this->args[] = $argv[$i];
			else
				break;
		}

		$this->args = array_reverse( $this->args );
	}

	public function flag( $name ) {
		return isset( $this->flags[$name] ) ? $this->flags[$name] : false;
	}
}
