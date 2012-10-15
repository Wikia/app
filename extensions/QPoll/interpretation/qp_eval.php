<?php
/**
 * ***** BEGIN LICENSE BLOCK *****
 * This file is part of QPoll.
 * Uses parts of code from Quiz extension (c) 2007 Louis-Rémi BABE. All rights reserved.
 *
 * QPoll is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * QPoll is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with QPoll; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * ***** END LICENSE BLOCK *****
 *
 * QPoll is a poll tool for MediaWiki.
 *
 * To activate this extension :
 * * Create a new directory named QPoll into the directory "extensions" of MediaWiki.
 * * Place the files from the extension archive there.
 * * Add this line at the end of your LocalSettings.php file :
 * require_once "$IP/extensions/QPoll/qp_user.php";
 *
 * @version 0.8.0a
 * @link http://www.mediawiki.org/wiki/Extension:QPoll
 * @author QuestPC <questpc@rambler.ru>
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( "This file is part of the QPoll extension. It is not a valid entry point.\n" );
}

class qp_Eval {

	# the list of allowed PHP tokens
	# filtered using the complete list at http://www.php.net/manual/ru/tokens.php
	# is it bullet-proof enough?
	static $allowedTokens = array(
		T_AND_EQUAL,
		T_ARRAY,
		T_AS,
		T_BOOLEAN_AND,
		T_BOOLEAN_OR,
		T_BOOL_CAST,
		T_BREAK,
		T_CASE,
		T_COMMENT,
		T_CONCAT_EQUAL,
		T_CONSTANT_ENCAPSED_STRING,
		T_CONTINUE,
		T_DEC,
		T_DEFAULT,
		T_DIV_EQUAL,
		T_DNUMBER,
		T_DOC_COMMENT,
		T_DOUBLE_ARROW,
		T_DOUBLE_CAST,
		T_ELSE,
		T_ELSEIF,
		T_EMPTY,
		T_ENCAPSED_AND_WHITESPACE,
		T_ENDFOREACH,
		T_ENDIF,
		T_ENDSWITCH,
		T_END_HEREDOC,
		T_FOREACH,
		T_FUNCTION,
		T_IF,
		T_INC,
		T_INT_CAST,
		T_ISSET,
		T_IS_EQUAL,
		T_IS_GREATER_OR_EQUAL,
		T_IS_IDENTICAL,
		T_IS_NOT_EQUAL,
		T_IS_NOT_IDENTICAL,
		T_IS_SMALLER_OR_EQUAL,
		T_LIST,
		T_LNUMBER,
		T_LOGICAL_AND,
		T_LOGICAL_OR,
		T_LOGICAL_XOR,
		T_MINUS_EQUAL,
		T_MOD_EQUAL,
		T_MUL_EQUAL,
		T_NUM_STRING,
		T_OR_EQUAL,
		T_PLUS_EQUAL,
		T_RETURN,
		T_SL,
		T_SL_EQUAL,
		T_SR,
		T_SR_EQUAL,
		T_START_HEREDOC,
		T_STRING,
		T_STRING_CAST,
		T_SWITCH,
		T_UNSET,
		T_UNSET_CAST,
		T_VARIABLE,
		T_WHITESPACE,
		T_XOR_EQUAL
	);

	# allowed functions
	static $allowedCalls = array(
		# math
		'round', 'ceil', 'floor',
		# arrays
		'is_array', 'array_key_exists', 'array_search', 'count', 'array_intersect', 'array_diff',
		'sort', 'asort', 'rsort', 'arsort',
		# types check and conversion
		'is_numeric', 'ctype_digit', 'intval', 'strval', 'floatval',
		# strings
		'trim', 'preg_match', 'preg_match_all', 'preg_split', 'qp_lc',
		# importing of structured interpretation from another polls
		'qp_getStructuredInterpretation',
		# debug
		'qp_debug'
	);

	# disallowed superglobals
	static $superGlobals = array(
		'$GLOBALS',
		'$_SERVER',
		'$_GET',
		'$_POST',
		'$_FILES',
		'$_REQUEST',
		'$_SESSION',
		'$_ENV',
		'$_COOKIE',
		'$php_errormsg',
		'$HTTP_RAW_POST_DATA',
		'$http_response_header',
		'$argc',
		'$argv'
	);

	# prefix added to local variable names which prevents
	# from accessing local scope variables in eval'ed code
	static $pseudoNamespace = 'qpv_';

	# the list of disallowed code
	# please add new entries, if needed.
	# key 'badresult' means that formally the code is allowed,
	# however the returned result has to be checked
	# (eg. variable substitution is incorrect)
	static $disallowedCode = array(
		array(
			'code' => '$test = $_SERVER["REQUEST_URI"];',
			'desc' => 'Disallow reading from superglobals'
		),
		array(
			'code' => '$GLOBALS["wgVersion"] = "test";',
			'desc' => 'Disallow writing to superglobals'
		),
		array(
			'code' => 'global $wgVersion;',
			'desc' => 'Disallow visibility of globals in local scope'
		),
		array(
			'code' => 'return $selfCheck == 1;',
			'badresult' => true,
			'desc' => 'Disallow access to extension\'s locals in the eval scope'
		),
		array(
			'code' => '$writevar = 1; $var = "writevar"; $$var = "test";',
			'desc' => 'Disallow writing to variable variables'
		),
		array(
			'code' => '$readvar = 1; $var = "readvar"; $test = $$var;',
			'desc' => 'Disallow reading from variable variables'
		),
		array(
			'code' => '$readvar = 1; $var = "readvar"; $test = "my$$var 1";',
			'desc' => 'Disallow reading from complex variable variables'
		),
		array(
			'code' => '$dh = opendir( "./" );',
			'desc' => 'Disallow illegal function calls'
		),
		array(
			'code' => '$func = "opendir"; $dh=$func( "./" );',
			'desc' => 'Disallow variable function calls'
		),
		array(
			'code' => 'return "test$selfCheck result";',
			'badresult' => 'test1 result',
			'desc' => 'Disallow extension\'s local scope variables in "simple" complex variables'
		),
		array(
			'code' => '$curlydollar = "1"; $var = "test{$curlydollar}a";',
			'desc' => 'Disallow complex variables (curlydollar)'
		),
		array(
			'code' => '$dollarcurly = "1"; $var = "test${dollarcurly}a";',
			'desc' => 'Disallow complex variables (dollarcurly)'
		),
		array(
			'code' => '$obj = new stdClass; $obj = new stdClass(); $obj -> a = 1;',
			'desc' => 'Disallow creation of objects'
		),
		array(
			'code' => '$obj -> a = 1;',
			'desc' => 'Disallow indirect creation of objects'
		),
		array(
			'code' => '$obj = (object) array("a"=>1);',
			'desc' => 'Disallow cast to objects'
		),
		array(
			'code' => 'for ( $i = 0; $i < 1; $i++ ) {};',
			'desc' => 'Disallow for loops, which easily can be made infinite'
		)
	);

	/**
	 * Calls php interpreter to lint interpretation script code
	 * @param  $code string with php code
	 * @return mixed
	 *   boolean  true, when code has no syntax errors;
	 *   string  error message from php lint;
	 */
	static function lint( $code ) {
		$pipes = array();
		$spec = array(
			0 => array( 'pipe', 'r' ),
			1 => array( 'pipe', 'w' ),
			2 => array( 'pipe', 'w' )
		);
		if ( !function_exists( 'proc_open' ) ) {
			return wfMsg( 'qp_error_eval_unable_to_lint' );
		}
		$process = proc_open( 'php -l', $spec, $pipes );
		if ( !is_resource( $process ) ) {
			return wfMsg( 'qp_error_eval_unable_to_lint' );
		}
		fwrite( $pipes[0], "<?php $code" );
		fclose( $pipes[0] );
		$out = array( 1 => '', 2 => '' );
		foreach ( $out as $key => &$text ) {
			while ( !feof( $pipes[$key] ) ) {
				$text .= fgets( $pipes[$key], 1024 );
			}
			fclose( $pipes[$key] );
		}
		$retval = proc_close( $process );
		if ( $retval == 0 ) {
			# no lint errors
			return true;
		}
		if ( ( $result = trim( implode( $out ) ) ) == '' ) {
			# lint errors but no meaningful error message
			return wfMsg( 'qp_error_eval_unable_to_lint' );
		}
		# lint error message
		return $result;
	}

	/**
	 * Check against the list of known disallowed code (for eval)
	 * should be executed before every eval, because PHP upgrade can introduce
	 * incompatibility leading to secure hole at any time
	 * @return
	 */
	static function selfCheck() {
		# remove unavailable functions from allowed calls list
		foreach ( self::$allowedCalls as $key => $fname ) {
			if ( !function_exists( $fname ) ) {
				unset( self::$allowedCalls[$key] );
			}
		}
		# the following var is used to check access to extension's locals
		# in the eval scope
		$selfCheck = 1;
		foreach ( self::$disallowedCode as $key => &$sourceCode ) {
			# check source code sample
			$destinationCode = '';
			$result = self::checkAndTransformCode( $sourceCode['code'], $destinationCode );
			if ( isset( $sourceCode['badresult'] ) ) {
				# the code is meant to be vaild, however the result may be insecure
				if ( $result !== true ) {
					# there is an error in sample
					return 'Sample error:' . $sourceCode['desc'];
				}
				# suppres PHP notices because some tests are supposed to generate them
				$old_reporting = error_reporting( E_ALL & ~E_NOTICE );
				$test_result = eval( $destinationCode );
				error_reporting( $old_reporting );
				# compare eval() result with "insecure" bad result
				if (  $test_result === $sourceCode['badresult'] ) {
					return $sourceCode['desc'];
				}
			} else {
				# the code meant to be invalid
				if ( $result === true ) {
					# illegal destination code which was passed as vaild
					return $sourceCode['desc'];
				}
			}
		}
		return true;
	}

	/**
	 * Checks the submitted eval code for errors
	 * In case of success returns transformed code, which is safer for eval
	 * @param $sourceCode  string
	 *   submitted code which has to be eval'ed (no php tags)
	 * @param $destinationCode  string
	 *   transformed code (in case of success) (no php tags)
	 * @return mixed
	 *   boolean  true in case of success;
	 *   string  error message on failure;
	 */
	static function checkAndTransformCode( $sourceCode, &$destinationCode ) {

		# tokenizer requires php tags to parse propely,
		# eval(), however requires not to have php tags - weird..
		$tokens = token_get_all( "<?php $sourceCode ?>" );
		/* remove <?php ?> */
		array_shift( $tokens );
		array_pop( $tokens );

		$destinationCode = '';
		$prev_token = null;
		foreach ( $tokens as $token ) {
			if ( is_array( $token ) ) {
				list( $token_id, $content, $line ) = $token;
				# check against generic list of disallowed tokens
				if ( !in_array( $token_id, self::$allowedTokens, true ) ) {
					return wfMsg( 'qp_error_eval_illegal_token', token_name( $token_id ), qp_Setup::specialchars( $content ), $line );
				}
				if ( $token_id == T_VARIABLE ) {
					$prev_content = is_array( $prev_token ) ? $prev_token[1] : $prev_token;
					preg_match( '`(\$)$`', $prev_content, $matches );
					# disallow variable variables
					if ( count( $matches ) > 1 && $matches[1] == '$' ) {
						return wfMsg( 'qp_error_eval_variable_variable_access', token_name( $token_id ), qp_Setup::specialchars( $content ), $line );
					}
					# disallow superglobals
					if ( in_array( $content, self::$superGlobals ) ) {
						return wfMsg( 'qp_error_eval_illegal_superglobal', token_name( $token_id ), qp_Setup::specialchars( $content ), $line );
					}
					# restrict variable names
					preg_match( '`^(\$)([A-Za-z0-9_]*)$`', $content, $matches );
					if ( count( $matches ) != 3 ) {
						return wfMsg( 'qp_error_eval_illegal_variable_name', token_name( $token_id ), qp_Setup::specialchars( $content ), $line );
					}
					# correct variable names into pseudonamespace 'qpv_'
					$content = "\$" . self::$pseudoNamespace . $matches[2];
				}
				# do not count whitespace as previous token
				if ( $token_id != T_WHITESPACE ) {
					$prev_token = $token;
				}
				# concat corrected token to the destination
				$destinationCode .= $content;
			} else {
				if ( $token == '(' && is_array( $prev_token ) ) {
					list( $token_id, $content, $line ) = $prev_token;
					# disallow variable function calls
					if ( $token_id === T_VARIABLE ) {
						return wfMsg( 'qp_error_eval_variable_function_call', token_name( $token_id ), qp_Setup::specialchars( $content ), $line );
					}
					# disallow non-allowed function calls based on the list
					if ( $token_id === T_STRING && array_search( $content, self::$allowedCalls, true ) === false ) {
						return wfMsg( 'qp_error_eval_illegal_function_call', token_name( $token_id ), qp_Setup::specialchars( $content ), $line );
					}
				}
				$prev_token = $token;
				# concat current token to the destination
				$destinationCode .= $token;
			}
		}

		return true;
	}

	/**
	 * Interpretates the answer with selected script
	 * @param $interpretScript
	 *   string  source code of interpretation script
	 * @param $injectVars
	 *   array of PHP data to inject into interpretation script;
	 *     key of element will become variable name in the interpretation script;
	 *     value of element will become variable value in the interpretation script;
	 * @param $interpResult  qp_InterpResult
	 * @modifies $interpResult
	 * @return  mixed
	 *   array script result to check
	 *   qp_InterpResult  $interpResult (in case of error)
	 */
	static function interpretAnswer(
			$interpretScript,
			array $injectVars,
			qp_InterpResult $interpResult ) {
		# template page evaluation
		if ( ( $check = self::selfCheck() ) !== true ) {
			# self-check error
			return $interpResult->setError( wfMsg( 'qp_error_eval_self_check', $check ) );
		}
		$evalScript = '';
		if ( ( $check = self::checkAndTransformCode( $interpretScript, $evalScript ) ) !== true ) {
			# possible malicious code
			return $interpResult->setError( $check );
		}
		# inject poll answer into the interpretation script
		$evalInject = '';
		foreach ( $injectVars as $varname => $var ) {
			$evalInject .= "\$" . self::$pseudoNamespace . "{$varname} = unserialize( base64_decode( '" . base64_encode( serialize( $var ) ) . "' ) ); ";
		}
		$evalScript = "{$evalInject}/* */ {$evalScript}";
		$result = eval( $evalScript );
		return $result;
	}

}
