<?php

/**
 * A PHP code beautifier aimed at adding lots of spaces to files that lack them,
 * in keeping with MediaWiki's spacey site style.
 */


if ( php_sapi_name() != 'cli' ) {
    print "This script must be run from the command line\n";
    exit( 1 );
}
// recurse all files: 
function listdir( $start_dir = '.' ) {

  $files = array();
  if ( is_dir( $start_dir ) ) {
    $fh = opendir( $start_dir );
    while ( ( $file = readdir( $fh ) ) !== false ) {
      # loop through the files, skipping . and .., and recursing if necessary
      if ( strcmp( $file, '.' ) == 0 || strcmp( $file, '..' ) == 0 ) continue;
      $filepath = $start_dir . '/' . $file;
      if ( is_dir( $filepath ) )
        $files = array_merge( $files, listdir( $filepath ) );
      else
        array_push( $files, $filepath );
    }
    closedir( $fh );
  } else {
    # false if the function was called with an invalid non-directory argument
    $files = false;
  }

  return $files;

}

$files = listdir( '.' );
$line_count = 0;
foreach ( $files as $file ) {
	if ( substr( $file, - 4 ) == '.php' ) {
		print 'do style: ' . $file . "\n";
		// stylize_file
		stylize_file( $file );
		$line_count += count( file( $file ) );
	}
}
print "did style on $line_count lines \n";

// print:da

/*array_shift( $argv );
if ( count( $argv ) ) {
    foreach ( $argv as $filename ) {
        stylize_file( $filename );
    }
} else {
    stylize_file( '-' );
}*/

function stylize_file( $filename ) {
    if ( $filename == '-' ) {
        $s = file_get_contents( '/dev/stdin' );
        if ( $s === false ) {
            return;
        }
        $stylizer = new Stylizer( $s );
        $s = $stylizer->stylize();
        echo $s;
    } else {
        $s = file_get_contents( $filename );
        if ( $s === false ) {
            return;
        }
        $stylizer = new Stylizer( $s );
        $s = $stylizer->stylize();
        rename( $filename, "$filename~" );
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
        '-',
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
        ')'
    );
    static $spaceAfter = array(
        '(',
        ';',
        ',',
    );
    static $closePairs = array(
        '(' => ')',
        '=' => '&',
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
            } elseif ( $curType == T_WHITESPACE ) {
                $curText = $this->fixWhitespace( $curText );
            }

            $out .= $curText;

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
        if ( preg_match( '!^(#|//)(\S.*)$!s', $s, $m ) ) {
            $s = $m[1] . ' ' . $m[2];
        }
        return $s;
    }

    function fixWhitespace( $s ) {
        // Fix whitespace at the line end
        return preg_replace( '!^([\t ]+)(\n.*)$!s', '\2', $s, 1 );
    }

}


